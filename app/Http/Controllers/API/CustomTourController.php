<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CustomTourRequest;
use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends BaseController
{
    public function store(CustomTourRequest $request)
    {
        $validated = $request->validated();

        $tourJsonData = $validated['tourJson'];

        // Perform basic data sanitization using strip_tags
        $sanitizedTourJson = $this->sanitizeData($tourJsonData);

        $record = CustomTour::create([
            'creator_email' => $validated['creatorEmail'],
            'marketing_opt_in' => $validated['marketingOptIn'] ?? false,
            'tour_json' => json_encode($sanitizedTourJson)
        ]);

        return response()->json(['message' => 'Custom tour created successfully!', 'custom_tour' => $record], 201);
    }

    public function show(Request $request, $id)
    {
        $customTour = CustomTour::find($id);

        if (!$customTour) {
            return response()->json(['message' => 'Custom tour not found'], 404);
        }

        $tourJson = $customTour->tour_json;

        return response()->json(['tourJson' => $tourJson], 200);
    }

    /**
     * Sanitize data received via the API
     *
     * This method strips HTML and PHP tags from data and returns the sanitized data
     *
     */
    private function sanitizeData(array $data): array
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
