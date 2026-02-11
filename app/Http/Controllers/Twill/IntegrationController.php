<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\Controller;
use App\Services\OAuth\GoogleOAuthService;
use App\Services\YouTube\YouTubeService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class IntegrationController extends Controller
{
    public function show()
    {
        $integrations = [
            'Google' => $this->getGoogleOAuthIntegration(),
            'YouTube' => $this->getYouTubeService(),
        ];


        return view('twill.integrations.show', [
            'items' => $integrations,
        ]);
    }

    public function action(string $service, string $action): RedirectResponse
    {
        switch ($service) {
            case class_basename(GoogleOAuthService::class):
                $googleOAuth = app(GoogleOAuthService::class);
                switch ($action) {
                    case 'refresh':
                        $googleOAuth->refreshAccess();
                        break;
                    case 'revoke':
                        $googleOAuth->revokeAccess();
                        break;
                    case 'delete':
                        $googleOAuth->deleteAccess();
                        break;
                }
                break;
        }

        return redirect()->route('twill.general.integrations.show');
    }

    private function getGoogleOAuthIntegration()
    {
        $googleOAuth = app(GoogleOAuthService::class);
        $hasAccess = $googleOAuth->hasAccess();
        if ($hasAccess) {
            $googleOAuth->authorizeAccess();
        }
        $isExpired = $googleOAuth->isAccessTokenExpired();

        $connection = $hasAccess ? ['enabled' => !$isExpired] : null;
        $name = class_basename(GoogleOAuthService::class);
        $message = $hasAccess ?
            ($isExpired ? 'Access token expired' : 'Access granted') :
            'Not authorized';
        $actions = array();
        if ($hasAccess) {
            $actions[] = [
                'name' => 'Revoke',
                'url' => route('twill.general.integrations.service.action', [
                    'service' => $name,
                    'action' => 'revoke',
                ])
            ];
            if ($isExpired) {
                $actions[] = [
                    'name' => 'Refresh',
                    'url' => route('twill.general.integrations.service.action', [
                        'service' => $name,
                        'action' => 'refresh',
                    ])
                ];
            }
            $actions[] = [
                'name' => 'Delete',
                'url' => route('twill.general.integrations.service.action', [
                    'service' => $name,
                    'action' => 'delete',
                ])
            ];
        } else {
            $actions[] = [
                'name' => 'Authorize',
                'url' => $googleOAuth->createAuthorizationUrl(),
            ];
        }

        $status = 'red';
        if ($connection && $connection['enabled'] ?? false) {
            $status = 'green';
        } elseif ($connection) {
            $status = 'yellow';
        }

        return [
            'connection' => $connection,
            'name' => $name,
            'status' => $status,
            'message' => $message,
            'actions' => $actions,
        ];
    }

    private function getYouTubeService()
    {
        $youTubeService = app(YouTubeService::class);

        $lastSucceededAt = Carbon::parse($youTubeService->getLastSucceededAt(), 'UTC');
        $lastFailedAt = Carbon::parse($youTubeService->getLastFailedAt(), 'UTC');
        $lastFailedReason = $youTubeService->getLastFailedReason();

        $status = 'red';
        if(Carbon::parse($lastSucceededAt)->gt($lastFailedAt)) {
            $status = 'green';
        }

        return [
            'last_succeeded_at' => $lastSucceededAt->tz('America/Chicago')->toDayDateTimeString(),
            'last_failed_at' => $lastFailedAt->gt($lastSucceededAt) ? $lastFailedAt->tz('America/Chicago')->toDayDateTimeString() : '',
            'message' => $lastFailedAt->gt($lastSucceededAt) ? $lastFailedReason : '',
            'status' => $status,
        ];
    }
}
