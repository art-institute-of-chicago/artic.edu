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

        return response()->json(['message' => 'Custom tour created successfully!', 'custom_tour' => $record], 201);
    }

    public function show(Request $request, $id)
    {
        $custom_tour = CustomTour::find($id);

        if (!$custom_tour) {
            return response()->json(['message' => 'Custom tour not found'], 404);
        }

        $tour_json = json_decode($custom_tour->tour_json, true);
        return response()->json(['tour_json' => $tour_json], 200);
    }
}
