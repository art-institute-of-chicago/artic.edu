<?php

namespace App\Http\Controllers;

use App\Models\CustomTour;
use App\Libraries\CustomTour\ArtworkSortingService;

class CustomTourController extends FrontController
{
    public function show($id)
    {
        $customTourItem = CustomTour::find($id);

        if (!$customTourItem) {
            return abort(404);
        }

        $customTour = json_decode($customTourItem->tour_json, true);

        ArtworkSortingService::sortArtworksByGallery($customTour['artworks'], config('galleries.order'));

        $this->seo->setTitle($customTour['title']);

        if (array_key_exists('description', $customTour)) {
            $this->seo->setDescription($customTour['description']);
        }

        $this->seo->nofollow = true;
        $this->seo->noindex = true;

        return view('site.customTour', ['id' => $customTourItem->id, 'custom_tour' => $customTour]);
    }

    public function showCustomTourBuilder()
    {
        return view('site.customTourBuilder');
    }
}
