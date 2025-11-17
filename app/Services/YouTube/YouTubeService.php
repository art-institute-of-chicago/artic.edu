<?php

namespace App\Services\YouTube;

use Google\Client;
use Google\Service\Exception as GoogleServiceException;
use Google\Service\Resource;
use Google\Service\YouTube;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class YouTubeService
{
    // The name to use for the user agent in requests
    public const SERVICE_NAME = 'The Art Institute of Chicago YouTube Service';

    // The api allows retrieving at most 50 items per request
    public const ITEMS_PER_REQUEST = 50;

    // See https://developers.google.com/youtube/v3/determine_quota_cost
    public const QUOTA_LIMIT = 10_000;
    private const QUOTAS = [
        'Captions' => [
            'download' => 200,
            'list' => 50,
        ],
        'Playlists' => [
            'list' => 1,
        ],
        'PlaylistItems' => [
            'list' => 1,
        ],
        'Videos' => [
            'list' => 1,
        ],
    ];

    // DB table storing quota useage by session
    private const SESSION_TABLE = 'youtube_service_sessions';
    private const PAGINATION_FIELDS = 'nextPageToken,pageInfo';
    private const REQUEST_FIELDS = 'kind';

    private YouTube $youtube;
    private $channelId;
    private $shortsPlaylistId;
    private $uploadPlaylistId;

    private $logger;

    // Session data
    private $forceLimit = false;
    private $requestCount = 0;
    private $sessionQuota = null;
    private $sessionUsage = 0;

    public function __construct(Client $client)
    {
        $this->youtube = new YouTube($client);
        $this->channelId = config('services.youtube.channel_id');
        $this->shortsPlaylistId = config('services.youtube.shorts_playlist_id');
        $this->uploadPlaylistId = config('services.youtube.upload_playlist_id');
    }

    public function setForceLimit(bool $forceLimit = false)
    {
        $this->forceLimit = $forceLimit;
    }

    public function setLogger($logger): void
    {
        $this->logger = $logger;
    }

    public function setSessionQuota(int $quota)
    {
        $this->sessionQuota = $quota;
    }

    public function getRequestCount(): int
    {
        return $this->requestCount;
    }

    public function getSessionUsage(): int
    {
        return $this->sessionUsage;
    }

    public function getQuotaType(): string
    {
        return is_null($this->sessionQuota) ? 'daily' : 'session';
    }

    /**
     * Calculate the amount of remaining quota points.
     */
    public function getRemainingQuota(bool $quiet = false): int
    {
        $type = $this->getQuotaType();
        if ($type == 'daily') {
            $quota = self::QUOTA_LIMIT;
            $usage = $this->todaysSessionsQuery()->sum('usage') + $this->sessionUsage;
        } elseif ($type == 'session') {
            $quota = $this->sessionQuota;
            $usage = $this->sessionUsage;
        }
        $remaining = $quota - $usage;
        if (!$quiet) {
            $this->log(
                "YouTube service quota - " .
                    "type: $type, " .
                    "quota: $quota, " .
                    "usage: $usage, " .
                    "remaining: $remaining",
            );
        }
        return $remaining;
    }

    /**
     * Return the datetime when the quota next resets.
     */
    public function getResetsAt($timezone = null)
    {
        $resetsAt = $this->lastResetAt()->addDay();
        if ($timezone) {
            $resetsAt->tz = $timezone;
        }
        return $resetsAt;
    }

    /**
     * Run tasks in the context of a session, tracking quota usage and requests.
     */
    public function session(\Closure $run, ?int $quota = null, bool $force = false): void
    {
        if (!is_null($quota)) {
            $this->setSessionQuota($quota);
        }
        $this->setForceLimit($force);
        $start = now('UTC');
        DB::table(self::SESSION_TABLE)->insert(['created_at' => $start]);
        try {
            $run();
        } catch (GoogleServiceException $exception) {
            $message = strip_tags(json_decode($exception->getMessage())->error->message);
            DB::table(self::SESSION_TABLE)->where('created_at', $start)->update([
                'errored_at' => now('UTC'),
                'error' => $exception->getMessage(),
                'message' => $message,
            ]);
            $this->log("YouTube service error - message: '$message'");
        } catch (YouTubeServiceException $exception) {
            DB::table(self::SESSION_TABLE)->where('created_at', $start)->update([
                'message' => $exception->getMessage(),
            ]);
        } finally {
            DB::table(self::SESSION_TABLE)->where('created_at', $start)->update([
                'updated_at' => now('UTC'),
                'requests' => $this->getRequestCount(),
                'usage' => $this->getSessionUsage(),
            ]);
        }
    }

    /**
     * Reset session-related data.
     */
    public function clearSession(): self
    {
        $this->forceLimit = false;
        $this->requestCount = 0;
        $this->sessionQuota = null;
        $this->sessionUsage = 0;

        return $this;
    }

    public function captionsForVideo(string $videoId, ?string $fields = null): array
    {
        $response = $this->request(
            resource: $this->youtube->captions,
            action: 'listCaptions',
            required: ['snippet', $videoId],
            optional: ['fields' => $fields],
        );

        return $response[$response['collection_key']];
    }

    public function downloadCaptionById(string $captionId): string
    {
        $response = $this->request(
            resource: $this->youtube->captions,
            action: 'download',
            required: [$captionId],
        );
        return (string) $response->getBody();
    }

    public function playlistCount(): int
    {
        $pageInfo = $this->pageInfo(
            resource: $this->youtube->playlists,
            action: 'listPlaylists',
            required: ['id'],
            optional: ['channelId' => $this->channelId],
        );
        return $pageInfo['totalResults'] ?? 0;
    }

    public function playlists(?string $fields = null): LazyCollection
    {
        return $this->allItems(
            resource: $this->youtube->playlists,
            action: 'listPlaylists',
            required: ['snippet'],
            optional: ['channelId' => $this->channelId, 'maxResults' => self::ITEMS_PER_REQUEST, 'fields' => $fields],
        );
    }

    public function shortsCount(): int
    {
        $pageInfo = $this->pageInfo(
            resource: $this->youtube->playlistItems,
            action: 'listPlaylistItems',
            required: ['id'],
            optional: ['playlistId' => $this->shortsPlaylistId],
        );
        return $pageInfo['totalResults'] ?? 0;
    }

    public function shorts(?string $fields = null): LazyCollection
    {
        return $this->itemsInPlaylist($this->shortsPlaylistId, $fields);
    }

    public function uploadCount(): int
    {
        $pageInfo = $this->pageInfo(
            resource: $this->youtube->playlistItems,
            action: 'listPlaylistItems',
            required: ['id'],
            optional: ['playlistId' => $this->uploadPlaylistId],
        );
        return $pageInfo['totalResults'] ?? 0;
    }

    public function uploads(?string $fields = null): LazyCollection
    {
        return $this->itemsInPlaylist($this->uploadPlaylistId, $fields);
    }

    public function itemsInPlaylist(string $playlistId, ?string $fields = null): LazyCollection
    {
        return $this->allItems(
            resource: $this->youtube->playlistItems,
            action: 'listPlaylistItems',
            required: ['snippet'],
            optional: ['playlistId' => $playlistId, 'maxResults' => self::ITEMS_PER_REQUEST, 'fields' => $fields],
        );
    }

    public function videosByIds(Collection $videoIds, ?string $fields = null): LazyCollection
    {
        return $this->allItems(
            resource: $this->youtube->videos,
            action: 'listVideos',
            required: ['contentDetails,snippet,status'],
            optional: ['id' => $videoIds->join(','), 'maxResults' => self::ITEMS_PER_REQUEST, 'fields' => $fields],
        );
    }

    /**
     * Retrieve only the first page's metadata.
     */
    private function pageInfo(Resource $resource, string $action, array $required, array $optional = []): array
    {
        return (array) $this->paginate($resource, $action, $required, $optional)->current()['pageInfo'];
    }

    /**
     * Return a lazy collection of all of the items from all of the pages for
     * the given resource.
     */
    private function allItems(Resource $resource, string $action, array $required, array $optional = []): LazyCollection
    {
        return LazyCollection::make(function () use ($resource, $action, $required, $optional) {
            foreach ($this->paginate($resource, $action, $required, $optional) as $page) {
                foreach ($page[$page['collection_key']] as $item) {
                    yield $item;
                }
            }
        });
    }

    /**
     * Retrieve all of the pages for a given resource.
     *
     * This generator lazily iterates thru all of the resource's pages.
     */
    private function paginate(Resource $resource, string $action, array $required, array $optional = [])
    {
        $pageCount = 0;
        $resultCount = 0;
        $nextPageToken = null;
        $optional['fields'] = trim(($optional['fields'] ?? '') . ',' . self::PAGINATION_FIELDS, ',');
        do {
            if ($nextPageToken) {
                $optional['pageToken'] = $nextPageToken;
            }

            $page = $this->request($resource, $action, $required, $optional);

            $pageResultCount = count($page[$page['collection_key']]);
            $resultCount += $pageResultCount;
            $results = "$pageResultCount";
            if (isset($page['pageInfo'])) {
                $results .= " ($resultCount/{$page['pageInfo']['totalResults']})";
            }
            $this->log("YouTube service page #$pageCount - results: $results");

            yield $page;

            $pageCount++;
            $nextPageToken = $page['nextPageToken'];
        } while ($nextPageToken);
    }

    public function request(Resource $resource, string $action, array $required, array $optional = [])
    {
        $estimatedUsage = $this->checkQuota($resource, $action);

        if ($action == 'download') {
            $details = '';
        } else {
            $optional['fields'] = trim(($optional['fields'] ?? '') . ',' . self::REQUEST_FIELDS, ',');
            $details = ", parts: '$required[0]', fields: '{$optional['fields']}'";
        }
        $this->log("YouTube service request #$this->requestCount - action: $action" . $details);

        $response = $resource->{$action}(...array_merge($required, [$optional]));

        if (is_a($response, \Google\Collection::class)) {
            $type = 'kind: ' . $response['kind'];
            $length = 'results: ' . count($response[$response['collection_key']]);
        } elseif (is_a($response, \GuzzleHttp\Psr7\Response::class)) {
            $type = 'content-type: ' . $response->getHeader('Content-Type')[0];
            $length = 'content-length: ' . $response->getHeader('Content-Length')[0];
        }
        $this->log("YouTube service response #$this->requestCount - $type, $length");

        $this->requestCount++;
        $this->sessionUsage += $estimatedUsage;

        return $response;
    }

    /**
     * Check that there is available quota for the resource action.
     */
    private function checkQuota($resource, $action): int
    {
        // Check that we haven't already received a "quota exceeded" error from YouTube
        $errored = $this->todaysSessionsQuery()->whereNotNull('errored_at');
        if ($session = $errored->whereJsonContains('error->error->errors->0->reason', 'quotaExceeded')->first()) {
            $this->log("YouTube service quota - exceeded: $session->errored_at", 'error');
            throw new YouTubeServiceException("Today's daily quota previously been exceeded at $session->errored_at");
        }

        $resourceName = class_basename($resource);
        $actionName = str($action)->ucsplit()->first();
        $estimatedUsage = self::QUOTAS[$resourceName][$actionName];
        $remaining = $this->getRemainingQuota();
        if ($estimatedUsage > $remaining) {
            $overage = $estimatedUsage - $remaining;
            $this->log(
                "YouTube service usage estimate - " .
                    "request: $resourceName $actionName, " .
                    "estimated usage: $estimatedUsage, " .
                    "remaining quota: $remaining, " .
                    "estimated overage: $overage",
                'warn',
            );
            if (!$this->forceLimit) {
                throw new YouTubeServiceException("The quota would be exceeded by an estimated $overage");
            }
        }

        return $estimatedUsage;
    }

    /**
     * "Daily quotas reset at midnight Pacific Time (PT)", see:
     * https://developers.google.com/youtube/v3/determine_quota_cost
     */
    private function lastResetAt()
    {
        return today('Pacific/Honolulu');
    }

    private function todaysSessionsQuery()
    {
        $lastResetAt = $this->lastResetAt();
        $lastResetAt->setTimezone('UTC');
        return DB::table(self::SESSION_TABLE)
            ->where('created_at', '>=', $lastResetAt)
            ->orderBy('created_at');
    }

    private function log($message, $level = 'info')
    {
        $logger = $this->logger;
        $logger($message, $level);
    }
}
