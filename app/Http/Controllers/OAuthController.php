<?php

namespace App\Http\Controllers;

use App\Services\OAuth\GoogleOAuthService;
use Illuminate\Http\Request;

class OAuthController extends Controller
{
    public function oauth(Request $request, GoogleOAuthService $oAuth): string
    {
        try {
            if ($oAuth->createAccessTokenWithAuthorizationCode($request->query('code'))) {
                $message = 'Authorization succeeded. You may close this tab.';
            } else {
                $message = 'Authorization failed!';
            }
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
        }

        return $message;
    }
}
