<?php

namespace App\Http\Controllers;

use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends Controller
{
    //

    public function storeDummyTours()
    {
        // Create a new record
        $model = new CustomTour;
        $model->id = '1234';
        $model->tour_json = [
            'title' => 'Custom Tour (Source)',
            'description' => 'Custom tour description',
            'artwork' => 'artwork_url',
        ];
        $model->save();

        // Create a new record
        $model = new CustomTour;
        $model->id = '1235';
        $model->tour_json = [
            'title' => 'Another Custom Tour (Source)',
            'description' => 'Another custom tour description',
            'artwork' => 'artwork_url',
        ];
        $model->save();
    }

    public function show()
    {
        $models = CustomTour::all();
        return view('site.example', ['models' => $models]);
    }
}
