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

    // Default metadata fields used for most requests
    private const METADATA_FIELDS = 'kind,nextPageToken,pageInfo';

    private YouTube $youtube;
    private $channelId;
    private $shortsPlaylistId;
    private $uploadPlaylistId;

    private $logger;

    // Session data
    private $forceLimit = false;
    private $metadataFields;
    private $requestCount = 0;
    private $sessionQuota = null;
    private $sessionUsage = 0;

    public function __construct(Client $client)
    {
        $this->youtube = new YouTube($client);
        $this->channelId = config('services.youtube.channel_id');
        $this->shortsPlaylistId = config('services.youtube.shorts_playlist_id');
        $this->uploadPlaylistId = config('services.youtube.upload_playlist_id');
        $this->setMetadataFields();
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

    public function setMetadataFields(?string $fields = self::METADATA_FIELDS): void
    {
        $this->metadataFields = $fields;
    }

    public function getRequestCount(): int
    {
        return $this->requestCount;
    }

    public function getSessionUsage(): int
    {
        return $this->sessionUsage;
    }

    /**
     * Calculate the amount of remaining quota points.
     */
    public function getRemainingQuota()
    {
        $type = is_null($this->sessionQuota) ? 'daily' : 'session';
        if ($type == 'daily') {
            $quota = self::QUOTA_LIMIT;
            $usage = $this->todaysSessionsQuery()->sum('usage') + $this->sessionUsage;
        } elseif ($type == 'session') {
            $quota = $this->sessionQuota;
            $usage = $this->sessionUsage;
        }
        $remaining = $quota - $usage;
        $this->log(
            "YouTube service quota - " .
                "type: $type, " .
                "quota: $quota, " .
                "usage: $usage, " .
                "remaining: $remaining",
        );
        return $remaining;
    }

    /**
     * Return the datetime when the quota next resets.
     */
    public function getResetsAt()
    {
        return $this->lastResetAt()->addDay();
    }

    public function session(\Closure $run, ?int $quota = null, bool $force = false): void
    {
        if (!is_null($quota)) {
            $this->setSessionQuota($quota);
        }
        $this->setForceLimit($force);
        $start = now();
        DB::table(self::SESSION_TABLE)->insert(['created_at' => $start]);
        try {
            $run();
        } catch (GoogleServiceException $exception) {
            $message = strip_tags(json_decode($exception->getMessage())->error->message);
            DB::table(self::SESSION_TABLE)->where('created_at', $start)->update([
                'errored_at' => now(),
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
                'updated_at' => now(),
                'requests' => $this->getRequestCount(),
                'usage' => $this->getSessionUsage(),
            ]);
        }
    }

    public function captionsForVideo(string $videoId, ?string $fields = null)
    {
        return $this->allItems(
            resource: $this->youtube->captions,
            action: 'listCaptions',
            required: ['snippet', $videoId],
            optional: ['fields' => $fields],
        );
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
            required: ['contentDetails,snippet'],
            optional: ['id' => $videoIds->join(','), 'maxResults' => self::ITEMS_PER_REQUEST, 'fields' => $fields],
        );
    }

    /**
     * Retrieve only the first page's metadata.
     */
    private function pageInfo(Resource $resource, string $action, array $required, array $optional): array
    {
        return (array) $this->allPages($resource, $action, $required, $optional)->current()['pageInfo'];
    }

    /**
     * Return a lazy collection of all of the items from all of the pages for
     * the given resource.
     */
    private function allItems(Resource $resource, $action, $required, $optional = []): LazyCollection
    {
        return LazyCollection::make(function () use ($resource, $action, $required, $optional) {
            foreach ($this->allPages($resource, $action, $required, $optional) as $page) {
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
    private function allPages($resource, $action, $required, $optional = [])
    {
        $resultCount = 0;
        $nextPageToken = null;
        $optional['fields'] = trim(($optional['fields'] ?? '') . ",$this->metadataFields", ',');
        do {
            $estimatedUsage = self::QUOTAS[class_basename($resource)][str($action)->ucsplit()->first()];
            $this->checkQuota($estimatedUsage);
            if ($nextPageToken) {
                $optional['pageToken'] = $nextPageToken;
            }
            $this->log(
                "YouTube service request #$this->requestCount - " .
                    "action: $action, " .
                    "parts: '{$required[0]}', " .
                    "fields: '{$optional['fields']}'",
            );

            $page = $resource->{$action}(...array_merge($required, [$optional]));

            $pageResultCount = count($page[$page['collection_key']]);
            $resultCount += $pageResultCount;
            $results = "$pageResultCount";
            if (isset($page['pageInfo'])) {
                $results .= " ($resultCount/{$page['pageInfo']['totalResults']})";
            }
            $this->log(
                "YouTube service response #$this->requestCount - " .
                    "kind: {$page['kind']}, " .
                    "results: $results"
            );
            $this->requestCount++;
            $this->sessionUsage += $estimatedUsage;

            yield $page;

            $nextPageToken = $page['nextPageToken'];
        } while ($nextPageToken);
    }

    /**
     * Check that there is available quota.
     */
    private function checkQuota(int $estimatedUsage): void
    {
        // Check that we haven't already received a "quota exceeded" error from YouTube
        $errored = $this->todaysSessionsQuery()->whereNotNull('errored_at');
        if ($session = $errored->whereJsonContains('error->error->errors->0->reason', 'quotaExceeded')->first()) {
            $this->log("YouTube service quota - exceeded: $session->errored_at");
            throw new YouTubeServiceException("Today's daily quota previously been exceeded at $session->errored_at");
        }

        $remaining = $this->getRemainingQuota();
        if ($estimatedUsage > $remaining) {
            $overage = $estimatedUsage - $remaining;
            $this->log(
                "YouTube service usage estimate - " .
                    "estimated usage: $estimatedUsage, " .
                    "estimated overage: $overage",
            );
            if (!$this->forceLimit) {
                throw new YouTubeServiceException("The quota would be exceeded by an estimated $overage");
            }
        }
    }

    /**
     * "Daily quotas reset at midnight Pacific Time (PT)", see:
     * https://developers.google.com/youtube/v3/determine_quota_cost
     */
    private function lastResetAt()
    {
        return today()->setTimezone('Pacific/Honolulu');
    }

    private function todaysSessionsQuery()
    {
        return DB::table(self::SESSION_TABLE)
            ->where('created_at', '>=', $this->lastResetAt())
            ->orderBy('created_at');
    }

    private function log($message)
    {
        $logger = $this->logger;
        $logger($message);
    }
}
