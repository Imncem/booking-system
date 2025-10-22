<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkingHour;
use App\Models\TimeOff;
use App\Models\Service;
use App\Models\Agent;
use App\Models\Booking;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AvailabilityController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name')->get();
        $agents = Agent::orderBy('name')->get();
        $working = WorkingHour::with('agent')->orderBy('agent_id')->orderBy('weekday')->get();
        $timeoffs = TimeOff::with('agent')->latest()->take(50)->get();
        return view('provider.availability', compact('services','agents','working','timeoffs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'weekday' => 'required|integer|min:0|max:6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        WorkingHour::updateOrCreate(
            ['agent_id'=>$data['agent_id'],'weekday'=>$data['weekday']],
            ['start_time'=>$data['start_time'],'end_time'=>$data['end_time']]
        );
        return back()->with('ok','Working hour saved.');
    }

    // Generate slots endpoint
    public function slots(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'service_id' => 'required|exists:services,id',
            'agent_id' => 'required|exists:agents,id',
        ]);

        $date = Carbon::parse($request->date)->startOfDay();
        $service = Service::findOrFail($request->service_id);
        $agentId = (int)$request->agent_id;

        // find working window for that weekday
        $wh = WorkingHour::where('agent_id',$agentId)->where('weekday', $date->dayOfWeek)->first();
        if (!$wh) return response()->json(['slots'=>[]]);

        $start = Carbon::parse($date->format('Y-m-d') . ' ' . $wh->start_time);
        $end   = Carbon::parse($date->format('Y-m-d') . ' ' . $wh->end_time);

        // timeoffs
        $offs = TimeOff::where('agent_id',$agentId)
            ->where(function($q) use($start,$end){
                $q->whereBetween('starts_at', [$start,$end])
                  ->orWhereBetween('ends_at', [$start,$end])
                  ->orWhere(function($qq) use($start,$end){
                        $qq->where('starts_at','<=',$start)->where('ends_at','>=',$end);
                  });
            })->get();

        // existing bookings
        $bookings = Booking::where('agent_id',$agentId)
            ->whereDate('starts_at', $date->toDateString())->get();

        $grid = (int) config('app.slot_granularity', 15); // minutes
        $bufferBefore = $service->buffer_before_min ?? 0;
        $bufferAfter = $service->buffer_after_min ?? 0;
        $dur = $service->duration_min;

        $slots = [];
        for ($t = $start->copy(); $t->lte($end->copy()->subMinutes($dur)); $t->addMinutes($grid)) {
            $slotStart = $t->copy()->addMinutes($bufferBefore);
            $slotEnd = $slotStart->copy()->addMinutes($dur);

            if ($slotEnd->gt($end)) continue;

            # check timeoffs overlap
            $blocked = false;
            foreach ($offs as $off) {
                if ($slotStart < $off->ends_at && $slotEnd > $off->starts_at) { $blocked = true; break; }
            }
            if ($blocked) continue;

            # check bookings overlap (include buffer after)
            $overlap = false;
            foreach ($bookings as $b) {
                $bStart = Carbon::parse($b->starts_at)->subMinutes($bufferBefore);
                $bEnd = Carbon::parse($b->ends_at)->addMinutes($bufferAfter);
                if ($slotStart < $bEnd && $slotEnd > $bStart) { $overlap = true; break; }
            }
            if ($overlap) continue;

            $slots[] = [
                'start' => $slotStart->toIso8601String(),
                'label' => $slotStart->format('g:i A'),
                'end'   => $slotEnd->toIso8601String(),
            ];
        }

        return response()->json(['slots'=>$slots]);
    }
}
