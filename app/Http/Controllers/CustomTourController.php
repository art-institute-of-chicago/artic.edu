<?php

namespace App\Http\Controllers;

use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends FrontController
{
    public function show($id)
    {
        $tour_item = CustomTour::find($id);

        if (!$tour_item) {
            return abort(404);
        }

        $tour = json_decode($tour_item->tour_json, true);

        $this->seo->setTitle($tour['title']);
        $this->seo->setDescription($tour['description']);
        return view('site.tour', ['id' => $tour_item->id, 'tour' => $tour]);
    }
}
