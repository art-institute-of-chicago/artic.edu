<?php

namespace App\Http\Controllers;

use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends Controller
{
    public function show($id)
    {
        $tour = CustomTour::find($id);

        $tour_json = json_decode($tour->tour_json, true);
        return view('site.tour', ['tour' => $tour, 'tour_json' => $tour_json]);
    }
}
