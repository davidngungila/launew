<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\IncidentReport;
use Illuminate\Http\Request;

class IncidentReportController extends Controller
{
    public function index()
    {
        $incidents = IncidentReport::with(['booking'])
            ->latest()
            ->paginate(20);

        return view('admin.operations.monitoring.incidents.index', compact('incidents'));
    }

    public function create()
    {
        $bookings = Booking::query()
            ->latest()
            ->limit(200)
            ->get();

        return view('admin.operations.monitoring.incidents.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'title' => 'required|string|max:255',
            'severity' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'occurred_at' => 'nullable|date',
            'description' => 'required|string',
            'resolution' => 'nullable|string',
        ]);

        $incident = IncidentReport::create([
            'booking_id' => $validated['booking_id'] ?? null,
            'reported_by_user_id' => auth()->id(),
            'title' => $validated['title'],
            'severity' => $validated['severity'],
            'status' => $validated['status'],
            'occurred_at' => $validated['occurred_at'] ?? null,
            'description' => $validated['description'],
            'resolution' => $validated['resolution'] ?? null,
        ]);

        return redirect()->route('admin.operations.monitoring.incidents.edit', $incident)->with('success', 'Incident report created successfully.');
    }

    public function edit(IncidentReport $incident)
    {
        $bookings = Booking::query()
            ->latest()
            ->limit(200)
            ->get();

        return view('admin.operations.monitoring.incidents.edit', compact('incident', 'bookings'));
    }

    public function update(Request $request, IncidentReport $incident)
    {
        $validated = $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'title' => 'required|string|max:255',
            'severity' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'occurred_at' => 'nullable|date',
            'description' => 'required|string',
            'resolution' => 'nullable|string',
        ]);

        $incident->update($validated);

        return redirect()->route('admin.operations.monitoring.incidents.index')->with('success', 'Incident report updated successfully.');
    }

    public function destroy(IncidentReport $incident)
    {
        $incident->delete();

        return redirect()->route('admin.operations.monitoring.incidents.index')->with('success', 'Incident report deleted successfully.');
    }
}
