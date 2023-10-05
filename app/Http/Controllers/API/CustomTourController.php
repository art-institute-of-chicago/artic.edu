<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Api\CustomTourRequest;
use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends BaseController
{
    public function store(CustomTourRequest $request)
    {
        // Perform basic data sanitization using strip_tags
        $sanitizedData = $this->sanitizeData($request);

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

    /**
     * Sanitize data received via the API
     *
     * This method strips HTML tags from data and returns the sanitized data
     *
     * @param object $data
     * @return object
     */
    private function sanitizeData($data)
    {
        $sanitizedData = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitizedData[$key] = $this->sanitizeData($value);
            } else {
                // Use strip_tags on strings only
                $sanitizedData[$key] = is_string($value) ? strip_tags($value) : $value;
            }
        }

        return $sanitizedData;
    }
}
