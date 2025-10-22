<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Agent;
use App\Models\Booking;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::orderBy('name')->get();
        $agents = Agent::orderBy('name')->get();
        $date = $request->query('date', Carbon::today()->toDateString());
        return view('customer.index', compact('services','agents','date'));
    }

    public function slots(Request $request)
    {
        // proxy to provider slots logic for simplicity
        $controller = new AvailabilityController();
        return $controller->slots($request);
    }

    public function confirm(Booking $booking)
    {
        return view('customer.confirm', compact('booking'));
    }
}
