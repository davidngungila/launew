<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = request()->user();

        $bookings = Booking::query()
            ->with('tour')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('client.dashboard', compact('bookings'));
    }
}
