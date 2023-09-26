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

        $tour = new CustomTour();
        $tour->id =  '1238';
        ;
        $tour->tour_json = json_encode([
            'title' => 'Another custom Tour (Source)',
            'description' => 'Another custom tour description',
            'artworks' => ['artwork_url_1', 'artwork_url_2'],
        ]);
        $tour->save();
//
//      return response()->json(['message' => 'Tour created successfully!', 'tour' => $tour], 201);
        return redirect('/example')->with('success', 'Item created successfully');
    }

    public function show()
    {
//        Add tours to db within show method
//        Todo: move to store method
//        $tour = new CustomTour();
//        $tour->id =  '1237';
//
//        $tour->tour_json = json_encode([
//            'title' => 'Another custom Tour (Source)',
//            'description' => 'Another custom tour description',
//            'artworks' => ['artwork_url_1', 'artwork_url_2'],
//        ]);
//        $tour->save();

        $tours = CustomTour::all();
        return view('site.example', ['tours' => $tours]);




    }
}
