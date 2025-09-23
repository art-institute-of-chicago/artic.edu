<?php

namespace App\Console\Commands;

use App\Models\Playlist;
use App\Models\Video;
use Google\Client;
use Google\Service\Resource;
use Google\Service\YouTube;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Symfony\Component\Console\Output\OutputInterface;

class ImportYouTubeData extends Command
{
    protected $signature = 'import:youtube';
    protected $description = 'Import video data from YouTube';

    // The api allows retrieving at most 50 videos per request.
    private const VIDEOS_PER_REQUEST = 50;

    private YouTube $youtube;
    private $channelId;
    private $shortsPlaylistId;
    private $uploadPlaylistId;

    // Used for debugging
    private $requestCount = 0;

    public function __construct()
    {
        parent::__construct();
        $client = new Client();
        $client->setApplicationName('Art Institute of Chicago Video Import');
        $client->setDeveloperKey(config('services.google_api.key'));
        $this->youtube = new YouTube($client);
        $this->channelId = config('services.youtube.channel_id');
        $this->shortsPlaylistId = config('services.youtube.shorts_playlist_id');
        $this->uploadPlaylistId = config('services.youtube.upload_playlist_id');
    }

    public function handle()
    {
        $this->info(
            "YouTube import session start",
            OutputInterface::VERBOSITY_DEBUG,
        );

        $this->info('Importing uploads');
        $sourceIds = $this->importUploads();
        $this->newLine();

        $this->info('Updating videos');
        $this->updateVideos($sourceIds);
        $this->newLine();

        $this->info('Indicating shorts');
        $this->indicateShorts();
        $this->newLine();

        $this->info('Syncing playlists');
        $this->syncPlaylists();
        $this->newLine();

        $this->info(
            "YouTube import session end - request count: $this->requestCount",
            OutputInterface::VERBOSITY_DEBUG
        );
        $this->info('YouTube import complete', OutputInterface::VERBOSITY_QUIET);
    }

    /**
     * Ensure a video entry exists for every item in the uploads playlist.
     */
    private function importUploads(): Collection
    {
        $progress = !$this->output->isDebug() ? $this->output->createProgressBar($this->uploadCount()) : null;
        $progress?->start();
        $sourceIds = collect();
        foreach ($this->uploads() as $upload) {
            $videoId = $upload['snippet']['resourceId']['videoId'];
            $sourceIds->push($videoId);
            Video::updateOrCreate(
                ['youtube_id' => $videoId],
                [
                    'youtube_id' => $videoId,
                    'title' => $upload['snippet']['title'],
                ],
            );
            $progress?->advance();
        }
        $progress?->finish();

        return $sourceIds;
    }

    /**
     * Iterate thru all source videos, updating the db record with data from the
     * api.
     */
    private function updateVideos(Collection $sourceIds): void
    {
        $progress = !$this->output->isDebug() ? $this->output->createProgressBar($sourceIds->count()) : null;
        $progress?->start();
        foreach ($sourceIds->chunk(self::VIDEOS_PER_REQUEST) as $chunkOfSourceIds) {
            $sourceVideos = $this->videosByIds($chunkOfSourceIds);
            foreach ($sourceVideos as $source) {
                $video = Video::firstWhere('youtube_id', $source['id'])->fill([
                    'title' => $source['snippet']['title'],
                    'description' => $source['snippet']['description'],
                    'uploaded_at' => $source['snippet']['publishedAt'],
                    'duration' => $this->convertDuration($source['contentDetails']['duration']),
                    'thumbnail_url' => $source['snippet']['thumbnails']['high']['url'],
                ]);
                $video->save();
                $progress?->advance();
            }
        }
        $progress?->finish();
    }

    /**
     * Set entries corresponding with items from the shorts playlist as shorts.
     */
    private function indicateShorts()
    {
        $progress = !$this->output->isDebug() ? $this->output->createProgressBar($this->shortsCount()) : null;
        $progress?->start();
        $sourceIds = $this->shorts()->pluck('snippet.resourceId.videoId')->all();
        Video::whereIn('youtube_id', $sourceIds)->update(['is_short' => true]);
        $progress?->finish();
    }

    /**
     * Ensure an entry exists for every playlist in the api and every playlist
     * item in the playlists.
     */
    private function syncPlaylists(): void
    {
        $progress = !$this->output->isDebug() ? $this->output->createProgressBar($this->playlistCount()) : null;
        $progress?->start();
        foreach ($this->playlists() as $sourcePlaylist) {
            $playlistId = $sourcePlaylist['id'];
            $playlist = Playlist::updateOrCreate(
                ['youtube_id' =>  $playlistId],
                [
                    'youtube_id' =>  $playlistId,
                    'title' => $sourcePlaylist['snippet']['title'],
                    'thumbnail_url' => $sourcePlaylist['snippet']['thumbnails']['high']['url'],
                ],
            );
            $sourcePlaylistItems = $this->itemsInPlaylist($playlistId)->all();
            $sourceVideoIdsByPosition = collect($sourcePlaylistItems)->pluck(
                'snippet.resourceId.videoId',
                'snippet.position',
            );
            $videoIdsToSync = Video::whereIn('youtube_id', $sourceVideoIdsByPosition->values())
                ->pluck('youtube_id', 'id')
                ->mapWithKeys(function ($youtubeId, $id) use ($sourceVideoIdsByPosition, $sourcePlaylistItems) {
                    $sourcePlaylistItem = collect($sourcePlaylistItems)->first(function ($item) use ($youtubeId) {
                        return $item['snippet']['resourceId']['videoId'] == $youtubeId;
                    });
                    return [$id => [
                        'position' => $sourceVideoIdsByPosition->flip()->get($youtubeId),
                        'youtube_id' => $sourcePlaylistItem['id'],
                    ]];
                });
            $playlist->videos()->sync($videoIdsToSync);
            $progress?->advance();
        }
        $progress?->finish();
    }

    /**
     * Convert a duration from 'PT1H1M1S' to '1:01:01'.
     */
    private function convertDuration(string $durationSpec): string
    {
        $interval = new \DateInterval($durationSpec);
        $format = '%S';
        if ($interval->h > 0) {
            $format = '%h:%I:' . $format;
        } else {
            $format = '%i:' . $format;
        }
        return $interval->format($format);
    }

    private function playlists(): LazyCollection
    {
        return $this->allItems(
            $this->youtube->playlists,
            'listPlaylists',
            'snippet',
            ['channelId' => $this->channelId],
        );
    }

    private function itemsInPlaylist(string $playlistId): LazyCollection
    {
        return $this->allItems(
            $this->youtube->playlistItems,
            'listPlaylistItems',
            'snippet',
            ['playlistId' => $playlistId],
        );
    }

    private function videosByIds(Collection $videoIds): LazyCollection
    {
        return $this->allItems(
            $this->youtube->videos,
            'listVideos',
            'contentDetails,snippet',
            ['id' => $videoIds->join(',')],
        );
    }

    private function shorts(): LazyCollection
    {
        return $this->itemsInPlaylist($this->shortsPlaylistId);
    }

    private function uploads(): LazyCollection
    {
        return $this->itemsInPlaylist($this->uploadPlaylistId);
    }

    private function playlistCount(): int
    {
        $pageInfo = $this->pageInfo(
            $this->youtube->playlists,
            'listPlaylists',
            'id',
            ['channelId' => $this->channelId],
        );
        return $pageInfo['totalResults'] ?? 0;
    }

    private function shortsCount(): int
    {
        $pageInfo = $this->pageInfo(
            $this->youtube->playlistItems,
            'listPlaylistItems',
            'id',
            ['playlistId' => $this->shortsPlaylistId],
        );
        return $pageInfo['totalResults'] ?? 0;
    }

    private function uploadCount(): int
    {
        $pageInfo = $this->pageInfo(
            $this->youtube->playlistItems,
            'listPlaylistItems',
            'id',
            ['playlistId' => $this->uploadPlaylistId],
        );
        return $pageInfo['totalResults'] ?? 0;
    }

    private function pageInfo($resource, $action, $parts, $options): array
    {
        return (array) $this->allPages($resource, $action, $parts, $options)->current()['pageInfo'];
    }

    /**
     * Return a lazy collection of all of the items from all of the pages for
     * the given resource.
     */
    private function allItems(Resource $resource, string $action, string $parts, array $options): LazyCollection
    {
        return LazyCollection::make(function () use ($resource, $action, $parts, $options) {
            foreach ($this->allPages($resource, $action, $parts, $options) as $page) {
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
    private function allPages(Resource $resource, string $action, string $parts, array $options)
    {
        $nextPageToken = null;
        do {
            $this->info(
                "YouTube import request #$this->requestCount - action: $action, parts: $parts",
                OutputInterface::VERBOSITY_DEBUG,
            );
            $page = $resource->{$action}($parts, $options + ['pageToken' => $nextPageToken]);
            $this->info(
                "YouTube import response #$this->requestCount - " .
                    "kind: {$page['kind']}, " .
                    "results: {$page['pageInfo']['resultsPerPage']}/{$page['pageInfo']['totalResults']}",
                OutputInterface::VERBOSITY_DEBUG,
            );
            $this->requestCount++;
            yield $page;

            $nextPageToken = $page['nextPageToken'];
        } while ($nextPageToken);
    }
}
