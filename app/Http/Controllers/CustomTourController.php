<?php

namespace App\Http\Controllers;

use App\Models\CustomTour;
use Illuminate\Http\Request;

class CustomTourController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'tour_json.title' => 'required|string',
            'tour_json.description' => 'required|string',
            'tour_json.artworks' => 'required|array'
        ]);

        //handle validation / sanitization / errors

        $tour = new CustomTour;
        $tour->id =  $request->input('id');;
        $tour->tour_json = [
            'title' => 'Custom Tour (Source)',
            'description' => 'Custom tour description',
            'artworks' => ['artwork_url_1', 'artwork_url_2'],
        ];
        $tour->save();

//        return response()->json(['message' => 'Tour created successfully!', 'tour' => $tour], 201);
        return redirect('/example')->with('success', 'Item created successfully');
    }

    public function show()
    {
        $models = CustomTour::all();
        return view('site.example', ['models' => $models]);
    }
}
