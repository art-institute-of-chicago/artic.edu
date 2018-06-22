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
            return ['message' => 'Successfully signed up to the newsletter.'];
        }

        return response()->json([
            'message' => 'The email must be a valid email address.',
        ], 500);

    }

}
