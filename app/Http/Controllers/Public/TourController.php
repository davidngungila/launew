<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index()
    {
        // For now using empty list or dummy data until seeder is ready
        $tours = Tour::where('status', 'active')->get();
        return view('tours.index', compact('tours'));
    }

    public function show($id)
    {
        // For now simple find or fail
        // $tour = Tour::with('itineraries')->findOrFail($id);
        return view('tours.show');
    }
}
