<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends BaseController
{
    public function store(Request $request)
    {
        $data = $request->json()->all();

        $record = CustomTour::create(['tour_json' => json_encode($data)]);

        return response()->json(['message' => 'Tour created successfully!', 'tour' => $record], 201);
    }

    public function show(Request $request, $id)
    {
        $tour = CustomTour::find($id);

        if (!$tour) {
            return response()->json(['message' => 'Tour not found'], 404);
        }

        $tour_json = json_decode($tour->tour_json, true);
        return response()->json(['tour_json' => $tour_json], 200);
    }
}
