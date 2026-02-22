<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::all();
        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        return view('admin.tours.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $tour = Tour::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'location' => $validated['location'],
            'duration_days' => $validated['duration_days'],
            'base_price' => $validated['base_price'],
            'description' => $validated['description'] ?? null,
            'images' => [],
            'inclusions' => [],
            'exclusions' => [],
            'package_destinations' => [],
            'target_markets' => [],
            'interactive_features' => [],
            'addons' => [],
            'conversion_triggers' => [],
            'featured' => false,
            'status' => 'active',
        ]);

        return redirect()->route('admin.tours.show', $tour)->with('success', 'Tour created successfully.');
    }

    public function show(Tour $tour)
    {
        return view('admin.tours.show', compact('tour'));
    }

    public function edit(Tour $tour)
    {
        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,draft',
            'featured' => 'nullable|boolean',
        ]);

        $tour->update([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'duration_days' => $validated['duration_days'],
            'base_price' => $validated['base_price'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'] ?? $tour->status,
            'featured' => (bool) ($validated['featured'] ?? $tour->featured),
        ]);

        return redirect()->route('admin.tours.show', $tour)->with('success', 'Tour updated successfully.');
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return redirect()->route('admin.tours.index')->with('success', 'Tour deleted successfully.');
    }
}
