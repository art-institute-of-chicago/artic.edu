<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\Controller;
use App\Services\OAuth\GoogleOAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class IntegrationController extends Controller
{
    public function show()
    {
        $integrations = array();

        $authorizationUrl = app(GoogleOAuthService::class)->createAuthorizationUrl();
        $credentials = DB::table('oauth')->where('provider', 'google')->first();
        $isConnected = (bool) $credentials?->access_token;
        $integrations[] = [
            'name' => class_basename(GoogleOAuthService::class),
            'provider' => $credentials?->provider,
            'authorizationUrl' => $isConnected ? null : $authorizationUrl,
            'connectedSince' => $credentials?->created_at,
            'isConnected' => $isConnected,
        ];

        return view('twill.integrations.show', ['items' => $integrations]);
    }

    public function disconnect($provider): RedirectResponse
    {
        DB::table('oauth')->where('provider', $provider)->delete();
        return redirect()->route('twill.general.integrations.show');
    }
}
