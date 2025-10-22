<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Agent;
use App\Models\Booking;
use Carbon\Carbon;

class ProviderController extends Controller
{
    public function dashboard(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString());
        $services = Service::orderBy('name')->get();
        $agents = Agent::orderBy('name')->get();
        $bookings = Booking::whereDate('starts_at', $date)->orderBy('starts_at')->get();
        return view('provider.dashboard', compact('date','services','agents','bookings'));
    }
}
