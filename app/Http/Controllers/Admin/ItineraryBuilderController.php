<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Itinerary;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItineraryBuilderController extends Controller
{
    public function index(Request $request)
    {
        $tours = Tour::orderBy('name')->get();

        $selectedTour = null;
        if ($request->filled('tour_id')) {
            $selectedTour = Tour::with('itineraries')->find($request->input('tour_id'));
        }

        return view('admin.tours.itinerary-builder', compact('tours', 'selectedTour'));
    }

    public function show(Request $request, Tour $tour)
    {
        $itineraries = $tour->itineraries()->get()->map(function (Itinerary $i) {
            return [
                'id' => $i->id,
                'day_number' => (int) $i->day_number,
                'title' => (string) $i->title,
                'description' => (string) $i->description,
                'accommodation' => $i->accommodation,
                'meals' => $i->meals,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => [
                'tour' => [
                    'id' => $tour->id,
                    'name' => $tour->name,
                    'location' => $tour->location,
                    'duration_days' => (int) $tour->duration_days,
                ],
                'itineraries' => $itineraries,
            ],
        ]);
    }

    public function save(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'itineraries' => 'required|array|min:1',
            'itineraries.*.day_number' => 'required|integer|min:1|max:365',
            'itineraries.*.title' => 'required|string|max:255',
            'itineraries.*.description' => 'required|string',
            'itineraries.*.accommodation' => 'nullable|string|max:255',
            'itineraries.*.meals' => 'nullable|string|max:255',
        ]);

        $rows = collect($validated['itineraries'])
            ->sortBy('day_number')
            ->values()
            ->map(function (array $row) use ($tour) {
                return [
                    'tour_id' => $tour->id,
                    'day_number' => (int) $row['day_number'],
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'accommodation' => $row['accommodation'] ?? null,
                    'meals' => $row['meals'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })
            ->all();

        DB::transaction(function () use ($tour, $rows) {
            Itinerary::where('tour_id', $tour->id)->delete();
            Itinerary::insert($rows);
        });

        return response()->json([
            'success' => true,
            'message' => 'Itinerary saved successfully',
        ]);
    }
}
