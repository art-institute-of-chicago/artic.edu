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
            'Google' => $this->getGoogleOAuthService(),
            'YouTube' => $this->getYouTubeService(),
        ];


        return view('twill.integrations.show', ['items' => $integrations]);
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

    private function getGoogleOAuthService()
    {
        $googleOAuth = app(GoogleOAuthService::class);
        $hasAccess = $googleOAuth->hasAccess();
        if ($hasAccess) {
            $googleOAuth->authorizeAccess();
        }
        $isExpired = $googleOAuth->isAccessTokenExpired();

        $status = $hasAccess ?
            ($isExpired ? 'yellow' : 'green') :
            'red';
        $updatedAt = Carbon::parse($googleOAuth->lastRefreshedAt(), 'UTC')->tz('America/Chicago');
        $message = $hasAccess ?
            ($isExpired ? 'Access token expired' : 'Access granted') :
            'Not authorized';
        $actions = array();
        if ($hasAccess) {
            $name = class_basename(GoogleOAuthService::class);
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

        return [
            'status' => $status,
            'updated_at' => $updatedAt->toDayDateTimeString(),
            'message' => $message,
            'actions' => $actions,
        ];
    }

    private function getYouTubeService()
    {
        $youTubeService = app(YouTubeService::class);
        $lastCompletedAt = Carbon::parse($youTubeService->getLastCompletedAt(), 'UTC')->tz('America/Chicago');
        $lastFailedAt = Carbon::parse($youTubeService->getLastFailedAt(), 'UTC')->tz('America/Chicago');
        $remainingQuota = $youTubeService->getRemainingQuota(quiet: true);

        $status = $lastCompletedAt->gt($lastFailedAt) ?
            ($remainingQuota ? 'green' : 'yellow') :
            'red';
        $message = '';
        if ($lastCompletedAt->equalTo($lastFailedAt)) {
            $message = $youTubeService->getLastFailedReason();
        } else {
            $message = 'Remaining quota: ' . $remainingQuota . '/' . $youTubeService::QUOTA_LIMIT;
        }

        return [
            'status' => $status,
            'updated_at' => $lastCompletedAt->toDayDateTimeString(),
            'message' => $message,
            'actions' => [],
        ];
    }
}
