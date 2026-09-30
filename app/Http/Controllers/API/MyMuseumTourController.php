<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\MyMuseumTourRequest;
use App\Models\Api\Artwork;
use App\Models\MyMuseumTour;
use App\Jobs\GeneratePdf;
use App\Jobs\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class MyMuseumTourController extends BaseController
{
    /**
     * Artwork fields requested from the API when saving a tour
     */
    private const ARTWORK_FIELDS = [
        'id',
        'title',
        'artist_title',
        'date_display',
        'short_description',
        'description',
        'image_id',
        'thumbnail',
        'gallery_title',
        'gallery_id',
    ];

    public function store(MyMuseumTourRequest $request)
    {
        $validated = $request->validated();

        $tourJson = $validated['tourJson'];
        $tourJson['artworks'] = $this->loadArtworks($tourJson['artworks']);

        $record = MyMuseumTour::create([
            'creator_email' => $validated['creatorEmail'],
            'marketing_opt_in' => $validated['marketingOptIn'] ?? false,
            'tour_json' => $tourJson
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
     * Reload artwork details from the API by ID
     *
     * Only each artwork's ID and objectNote are kept from the request. All other
     * details, including the description HTML that is rendered unescaped, come
     * from the API so they can't be tampered with by the client.
     */
    private function loadArtworks(array $artworks): array
    {
        $ids = array_column($artworks, 'id');

        $apiArtworks = Artwork::query()
            ->ids($ids)
            ->get(self::ARTWORK_FIELDS)
            ->keyBy('id');

        $missingIds = array_diff($ids, $apiArtworks->keys()->all());

        if ($missingIds) {
            throw ValidationException::withMessages([
                'tourJson.artworks' => 'These artworks could not be found: ' . implode(', ', $missingIds),
            ]);
        }

        return array_map(function ($artwork) use ($apiArtworks) {
            $apiArtwork = $apiArtworks[$artwork['id']];

            return [
                'id' => $apiArtwork->id,
                'title' => $apiArtwork->title,
                'artist_title' => $apiArtwork->artist_title,
                'display_date' => $apiArtwork->date_display,
                // Matches the builder, which shows short_description and falls back to description
                'description' => $apiArtwork->short_description ?: $apiArtwork->description,
                'image_id' => $apiArtwork->image_id,
                'thumbnail' => $apiArtwork->thumbnail
                    ? Arr::only((array) $apiArtwork->thumbnail, ['lqip', 'width', 'height', 'alt_text'])
                    : null,
                'gallery_title' => $apiArtwork->gallery_title,
                'gallery_id' => $apiArtwork->gallery_id,
                'objectNote' => $artwork['objectNote'] ?? null,
            ];
        }, $artworks);
    }
}
