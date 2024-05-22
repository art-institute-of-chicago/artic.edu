<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\MyMuseumTourRequest;
use App\Models\MyMuseumTour;
use App\Jobs\GeneratePdf;
use App\Jobs\Subscribe;
use Illuminate\Http\Request;

class MyMuseumTourController extends BaseController
{
    public function store(MyMuseumTourRequest $request)
    {
        $validated = $request->validated();

        $tourJsonData = $validated['tourJson'];

        // Perform basic data sanitization using strip_tags
        $sanitizedTourJson = $this->sanitizeData($tourJsonData);

        $record = MyMuseumTour::create([
            'creator_email' => $validated['creatorEmail'],
            'marketing_opt_in' => $validated['marketingOptIn'] ?? false,
            'tour_json' => $sanitizedTourJson
        ]);

        GeneratePdf::dispatch($record);
        if ($validated['marketingOptIn']) {
            Subscribe::dispatch($validated['creatorEmail']);
        }

        return response()->json(['message' => 'My Museum Tour created successfully!', 'my_museum_tour' => $record], 201);
    }

    public function show(Request $request, $id)
    {
        $myMuseumTour = MyMuseumTour::find($id);

        if (!$myMuseumTour) {
            return response()->json(['message' => 'My Museum Tour not found'], 404);
        }

        $tourJson = $myMuseumTour->tour_json;

        return response()->json(['tourJson' => $tourJson], 200);
    }

    /**
     * Sanitize data received via the API
     *
     * This method strips HTML and PHP tags from data and returns the sanitized data
     *
     */
    private function sanitizeData(array $data, string $parentKey = ''): array
    {
        $sanitizedData = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitizedData[$key] = $this->sanitizeData($value, $key);
            } else {
                // Use strip_tags on strings only. 'description' with a parentKey that's an integer is the short_description, so don't strip that one
                $sanitizedData[$key] = is_string($value) && !($key == 'description' && is_numeric($parentKey)) ? strip_tags($value) : $value;
            }
        }

        return $sanitizedData;
    }
}
