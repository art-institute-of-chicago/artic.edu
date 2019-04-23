<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Libraries\ExactTargetService;

class SubscribeController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate(['email'=>'required|email']);

        $exactTarget = new ExactTargetService(request('email'), request('list'));
        $response = $exactTarget->subscribe();

        if ($response === true) {
            return ['message' => 'Successfully signed up to the newsletter.'];
        }

        $error = $response->results[0]->ErrorMessage ?? '';

        if (Str::startsWith($error, 'Violation of PRIMARY KEY constraint'))
        {
            return response()->json([
                'message' => 'It looks like this email address is already receiving the newsletter.',
            ], 400);
        }

        return response()->json([
            'message' => 'Error signing up to the newsletter. Please check your email address and try again.',
        ], 500);

    }

}
