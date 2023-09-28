<?php

namespace App\Http\Controllers;

use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->json()->all();
        $record = CustomTour::create(['tour_json' => json_encode($data)]);

        return response()->json(['message' => 'Tour created successfully!', 'tour' => $record], 201);
    }

    public function show($id)
    {
        $tour = CustomTour::find($id);

        $tour_json = json_decode($tour->tour_json, true);
        return view('site.tour', ['tour' => $tour, 'tour_json' => $tour_json]);
    }
}
