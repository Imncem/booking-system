<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Agent;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'agent_id' => 'required|exists:agents,id',
            'starts_at' => 'required|date',
            'customer_name' => 'required|string|max:120',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:30',
        ]);

        $service = Service::findOrFail($data['service_id']);
        $start = Carbon::parse($data['starts_at']);
        $end = $start->copy()->addMinutes($service->duration_min);

        $booking = Booking::create([
            'agent_id' => $data['agent_id'],
            'service_id' => $service->id,
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'] ?? null,
            'customer_phone' => $data['customer_phone'] ?? null,
            'starts_at' => $start,
            'ends_at' => $end,
            'status' => 'awaiting_payment',
            'price_cents' => $service->price_cents ?? 0,
            'deposit_cents' => $service->deposit_cents ?? 0,
            'balance_cents' => max(0, ($service->price_cents ?? 0) - ($service->deposit_cents ?? 0)),
        ]);

        // TODO: redirect to Bizappay checkout (placeholder)
        return redirect()->route('customer.confirm', $booking);
    }
}
