<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscribeController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate(['email'=>'required|email']);

        // TODO Subscribe to list via ExactTarget API
        $response = true;
        if ($response) {
            return ['message' => 'Added successfully'];
        }

        return response()->json([
            'message' => 'Invalid email address',
        ], 500);

    }

}
