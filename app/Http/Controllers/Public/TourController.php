<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::where('status', 'active')->orderBy('featured', 'desc')->get();
        return view('tours.index', compact('tours'));
    }

    public function show($id)
    {
        $tour = Tour::with('itineraries')->findOrFail($id);
        return view('tours.show', compact('tour'));
    }
}
