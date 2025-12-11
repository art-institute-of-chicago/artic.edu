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
        $this->client->setTokenCallback($this->newAccessTokenCallback(...));
    }

    /**
     * Set the application name in the user agent.
     */
    public function setApplicationName($name): void
    {
        // See https://developers.google.com/youtube/v3/getting-started#gzip
        $this->client->setApplicationName($name . ' (gzip)');
    }

    /**
     * Return the url needed to for the user to start the OAuth process.
     */
    public function createAuthorizationUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Once a user has authorized the application, use the code to fetch an
     * access token from Google and save it.
     *
     * Return true if creating and saving the access token was successful.
     *
     * Throws an exception if there was an error fetching the access token.
     */
    public function createAccessTokenWithAuthorizationCode(string $code): bool
    {
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
        if ($accessToken['error'] ?? false) {
            throw new GoogleOAuthServiceException('Error fetching access token: ' . $accessToken['error_description']);
        }
        return (bool) DB::table('oauth')->insert([
            'created_at' => now(),
            'provider' => self::PROVIDER,
            'access_token' => json_encode($accessToken),
        ]);
    }

    /**
     * Return true if the acces token has expired.
     */
    public function isAccessTokenExpired(): bool
    {
        return $this->client->isAccessTokenExpired();
    }

    public function hasAccess(): bool
    {
        return (bool) DB::table('oauth')->where(['provider' => self::PROVIDER])->count();
    }

    /**
     * Retrieve the stored access token, then authorize the Google client with
     * it.
     */
    public function authorizeAccess(): void
    {
        $accessToken = $this->retrieveAccessToken();
        $this->client->setAccessToken($accessToken);
        $this->client->authorize();
    }

    /**
     * Retrieve the refresh token from the stored access token, then use it to
     * fetch and store a new access token.
     *
     * Returns the stored refreshed token.
     */
    public function refreshAccess(): array
    {
        $accessToken = $this->retrieveAccessToken();
        $refreshedAccessToken = $this->client->fetchAccessTokenWithRefreshToken($accessToken['refresh_token']);
        if (array_key_exists('error', $refreshedAccessToken)) {
            throw new GoogleOAuthServiceException(
                'Unable to refresh access token: ' . $refreshedAccessToken['error_description']
            );
        }

        return $this->storeAccessToken($refreshedAccessToken);
    }

    /**
     * Retrieve the stored access token, revoke it's access, then delete it.
     *
     * Return true if access was revoked successfully.
     *
     * Throws an exception if revoking the token was unsuccessful.
     */
    public function revokeAccess(): bool
    {
        $token = $this->retrieveAccessToken();
        if ($this->client->revokeToken($token)) {
            return (bool) DB::table('oauth')->where('provider', self::PROVIDER)->delete();
        } else {
            throw new GoogleOAuthServiceException('Unable to revoke token access!');
        }
    }

    /**
     * Get the current access token from the database record.
     *
     * Return the access token as an associative array.
     *
     * Throws an exception if no access token is found.
     */
    private function retrieveAccessToken(): array
    {
        $accessToken = DB::table('oauth')->where('provider', self::PROVIDER)->pluck('access_token')->first();
        if (!$accessToken) {
            throw new GoogleOAuthServiceException('No access token stored!');
        }

        return json_decode($accessToken, true);
    }

    /**
     * Update the current access token with new data and store it.
     *
     * Return the updated access token.
     *
     * Throws an exception if the update is unsuccessful.
     */
    private function storeAccessToken(array $newAccessToken): array
    {
        $accessToken = $this->retrieveAccessToken();
        $updatedAccessToken = array_merge($accessToken, $newAccessToken);
        if (
            DB::table('oauth')->where('provider', self::PROVIDER)->update([
                'updated_at' => now(),
                'access_token' => $updatedAccessToken,
            ])
        ) {
            return $updatedAccessToken;
        } else {
            throw new GoogleOAuthServiceException('Unable to update access token!');
        }
    }

    /**
     * The hook called when the OAuth client automatically attempts to refresh
     * the token if it is expired on authorization.
     *
     * Store the updated access token and set it on the client.
     */
    private function newAccessTokenCallback($cacheKey, string $accessToken): void
    {
        $token = [
            'access_token' => $accessToken,
            'created' => time(),
        ];
        $updatedToken = $this->storeAccessToken($token);
        $this->client->setAccessToken($updatedToken);
    }
}
