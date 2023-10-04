<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends BaseController
{
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'title' => 'required|string',
                'description' => 'nullable|string',
                'artworks' => 'required|array',
                'artworks.*.id' => 'required|integer',
                'artworks.*.title' => 'required|string',
                'artworks.*.url' => 'required|string',
                'artworks.*.objectNote' => 'nullable|string',
            ]
        );

        // Perform basic data sanitization using strip_tags
        $sanitizedData = $this->sanitizeData($data);

        $record = CustomTour::create(['tour_json' => json_encode($sanitizedData)]);

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

    private function sanitizeData($data)
    {
        $sanitizedData = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // If the value is an array, recursively sanitize it
                $sanitizedData[$key] = $this->sanitizeData($value);
            } else {
                // Use strip_tags to remove HTML and PHP tags only for strings
                $sanitizedData[$key] = is_string($value) ? strip_tags($value) : $value;
            }
        }

        return $sanitizedData;
    }
}
