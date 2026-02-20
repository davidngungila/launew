<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function home()
    {
        $featuredTours = Tour::where('status', 'active')->where('featured', true)->take(3)->get();
        return view('home', compact('featuredTours'));
    }

    public function index(Request $request)
    {
        $query = Tour::where('status', 'active');

        // Apply Destination Filter
        if ($request->filled('destination') && $request->destination !== 'All') {
            $query->where('location', 'like', '%' . $request->destination . '%');
        }

        // Apply Duration Filter
        if ($request->filled('duration')) {
            if ($request->duration === '1-3 Days') {
                $query->whereBetween('duration_days', [1, 3]);
            } elseif ($request->duration === '4-7 Days') {
                $query->whereBetween('duration_days', [4, 7]);
            } elseif ($request->duration === '8+ Days') {
                $query->where('duration_days', '>=', 8);
            }
        }

        // Apply Sorting
        if ($request->filled('sort')) {
            if ($request->sort === 'Low to High') {
                $query->orderBy('base_price', 'asc');
            } elseif ($request->sort === 'High to Low') {
                $query->orderBy('base_price', 'desc');
            }
        } else {
            $query->orderBy('featured', 'desc');
        }

        $tours = $query->paginate(6);

        if ($request->ajax()) {
            return view('tours.partials.tour_grid', compact('tours'))->render();
        }

        return view('tours.index', compact('tours'));
    }

    public function show($id)
    {
        $tour = Tour::with('itineraries')->findOrFail($id);
        return view('tours.show', compact('tour'));
    }
}
