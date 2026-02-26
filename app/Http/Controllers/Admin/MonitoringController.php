<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CustomerFeedback;
use App\Models\IncidentReport;

class MonitoringController extends Controller
{
    public function status()
    {
        $today = now()->toDateString();

        $stats = [
            'active_trips' => Booking::where('status', 'confirmed')
                ->whereDate('start_date', '<=', $today)
                ->count(),
            'pending_incidents' => IncidentReport::whereIn('status', ['open', 'in_progress'])->count(),
            'new_feedback' => CustomerFeedback::where('status', 'new')->count(),
        ];

        $recentIncidents = IncidentReport::with('booking')
            ->latest()
            ->limit(6)
            ->get();

        $recentFeedback = CustomerFeedback::with('booking')
            ->latest()
            ->limit(6)
            ->get();

        return view('admin.operations.monitoring.status', compact('stats', 'recentIncidents', 'recentFeedback'));
    }
}
