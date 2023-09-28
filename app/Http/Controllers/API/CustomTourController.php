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
}
