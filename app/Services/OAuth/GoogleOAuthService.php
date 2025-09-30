<?php

namespace App\Services\OAuth;

use Google\Client;
use Illuminate\Support\Facades\DB;

class GoogleOAuthService
{
    private const ACCESS_TYPE = 'offline';
    private const PROVIDER = 'google';
    private const SCOPES = [
        'https://www.googleapis.com/auth/youtube.force-ssl',
        'https://www.googleapis.com/auth/youtubepartner',
    ];

    public Client $client;

    public function __construct(string $developerKey, array|string $authConfig)
    {
        // See https://developers.google.com/youtube/v3/getting-started#gzip
        $clientConfig = ['headers' => ['Accept-Encoding' => 'gzip']];
        $this->client = new Client($clientConfig);
        $this->client->setDeveloperKey($developerKey);
        $this->client->setAuthConfig($authConfig);
        $this->client->setAccessType(self::ACCESS_TYPE);
        $this->client->setScopes(self::SCOPES);
    }

    public function setApplicationName($name): void
    {
        $this->client->setApplicationName($name);
    }

    public function createAuthorizationUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    public function createAccessTokenWithAuthorizationCode(string $code): bool
    {
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
        if ($accessToken['error'] ?? false) {
            throw new \Exception('Error fetching access token: ' . $accessToken['error_description']);
        }
        return (bool) DB::table('oauth')->insert([
            'created_at' => now(),
            'provider' => self::PROVIDER,
            'authorization_code' => $code,
            'access_token' => json_encode($accessToken),
        ]);
    }
}
