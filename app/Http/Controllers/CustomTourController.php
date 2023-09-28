<?php

namespace App\Http\Controllers;

use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends FrontController
{
    public function show($id)
    {
        $tour = CustomTour::find($id);

        if (!$tour) {
            return abort(404);
        }

        $tour_json = json_decode($tour->tour_json, true);

        $this->seo->setTitle($tour_json['title']);
        $this->seo->setDescription($tour_json['description']);
        return view('site.tour', ['tour' => $tour, 'tour_json' => $tour_json]);
    }
}
