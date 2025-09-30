<?php

namespace App\Http\Controllers;

use App\Services\OAuth\GoogleOAuthService;
use Illuminate\Http\Request;

class OAuthController extends Controller
{
    public function oauth(Request $request, GoogleOAuthService $oAuth): string
    {
        if ($oAuth->createAccessTokenWithAuthorizationCode($request->query('code'))) {
            return 'Authorization succeeded. You may close this tab.';
        } else {
            return 'Authorization failed!';
        }
    }
}
