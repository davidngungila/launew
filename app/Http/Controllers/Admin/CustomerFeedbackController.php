<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CustomerFeedback;
use Illuminate\Http\Request;

class CustomerFeedbackController extends Controller
{
    public function index()
    {
        $feedback = CustomerFeedback::with(['booking'])
            ->latest()
            ->paginate(20);

        return view('admin.operations.monitoring.feedback.index', compact('feedback'));
    }

    public function create()
    {
        $bookings = Booking::query()
            ->latest()
            ->limit(200)
            ->get();

        return view('admin.operations.monitoring.feedback.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'required|in:new,reviewed,actioned,archived',
            'submitted_at' => 'nullable|date',
            'message' => 'required|string',
        ]);

        $row = CustomerFeedback::create($validated);

        return redirect()->route('admin.operations.monitoring.feedback.edit', $row)->with('success', 'Customer feedback captured successfully.');
    }

    public function edit(CustomerFeedback $feedback)
    {
        $bookings = Booking::query()
            ->latest()
            ->limit(200)
            ->get();

        return view('admin.operations.monitoring.feedback.edit', compact('feedback', 'bookings'));
    }

    public function update(Request $request, CustomerFeedback $feedback)
    {
        $validated = $request->validate([
            'booking_id' => 'nullable|exists:bookings,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'required|in:new,reviewed,actioned,archived',
            'submitted_at' => 'nullable|date',
            'message' => 'required|string',
        ]);

        $feedback->update($validated);

        return redirect()->route('admin.operations.monitoring.feedback.index')->with('success', 'Customer feedback updated successfully.');
    }

    public function destroy(CustomerFeedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.operations.monitoring.feedback.index')->with('success', 'Customer feedback deleted successfully.');
    }
}
