<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\ExactTargetService;

class SubscribeController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate(['email'=>'required|email']);

        $exactTarget = new ExactTargetService(request('email'), request('list'));
        $exactTarget->subscribe();

        $response = true;
        if ($response) {
            return ['message' => 'Successfully signed up to the newsletter.'];
        }

        return response()->json([
            'message' => 'The email must be a valid email address.',
        ], 500);

    }

}
