<?php

namespace App\Http\Controllers;

use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends FrontController
{
    public function show($id)
    {
        $custom_tour_item = CustomTour::find($id);

        if (!$custom_tour_item) {
            return abort(404);
        }

        $custom_tour = json_decode($custom_tour_item->tour_json, true);

        $this->seo->setTitle($custom_tour['title']);

        if (array_key_exists('description', $custom_tour)) {
            $this->seo->setDescription($custom_tour['description']);
        }

        $this->seo->nofollow = true;
        $this->seo->noindex = true;

        return view('site.customTour', ['id' => $custom_tour_item->id, 'custom_tour' => $custom_tour]);
    }
}
