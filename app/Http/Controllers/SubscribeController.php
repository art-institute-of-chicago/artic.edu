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
        $response = $exactTarget->subscribe();

        if ($response === true) {
            return ['message' => 'Successfully signed up to the newsletter.'];
        }

        return response()->json([
            'message' => 'Error signing up to the newsletter. Please check your email address and try again.',
        ], 500);

    }

}
