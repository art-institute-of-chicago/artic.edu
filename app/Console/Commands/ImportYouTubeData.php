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

class ImportYouTubeData extends Command
{
    protected $signature = 'import:youtube';
    protected $description = 'Import video data from YouTube';

    private const CHANNEL_ID = 'UCXflF3_PL_QuDX1CsCImuFA';
    private const UPLOAD_PLAYLIST_ID = 'UUXflF3_PL_QuDX1CsCImuFA';

    // The api allows retrieving at most 50 videos per request.
    private const VIDEOS_PER_REQUEST = 50;

    private YouTube $youtube;

    public function __construct()
    {
        parent::__construct();
        $client = new Client();
        $client->setApplicationName('Art Institute of Chicago Video Import');
        $client->setDeveloperKey(config('services.google_api.key'));
        $this->youtube = new YouTube($client);
    }

    public function handle()
    {
        $this->info('Importing uploads');
        $sourceIds = $this->importUploads();
        $this->newLine();

        $this->info('Updating videos');
        $this->updateVideos($sourceIds);
        $this->newLine();

        $this->info('Syncing playlists');
        $this->syncPlaylists();
        $this->newLine();

        $this->info('YouTube import complete');
    }

    /**
     * Ensure a video entry exists for every item in the uploads playlist.
     */
    private function importUploads(): Collection
    {
        $progress = $this->output->createProgressBar($this->uploadCount());
        $progress->start();
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
            $progress->advance();
        }
        $progress->finish();

        return $sourceIds;
    }

    /**
     * Iterate thru all source videos, updating the db record with data from the
     * api.
     */
    private function updateVideos(Collection $sourceIds): void
    {
        $progress = $this->output->createProgressBar($sourceIds->count());
        $progress->start();
        foreach ($sourceIds->chunk(self::VIDEOS_PER_REQUEST) as $chunkOfSourceIds) {
            $sourceVideos = $this->videosByIds($chunkOfSourceIds);
            foreach ($sourceVideos as $source) {
                $video = Video::firstWhere('youtube_id', $source['id'])->fill([
                    'title' => $source['snippet']['title'],
                    'list_description' => $source['snippet']['description'],
                    'uploaded_at' => $source['snippet']['publishedAt'],
                    'duration' => $this->convertDuration($source['contentDetails']['duration']),
                    'thumbnail_url' => $source['snippet']['thumbnails']['high']['url'],
                ]);
                $video->save();
                $progress->advance();
            }
        }
        $progress->finish();
    }

    /**
     * Ensure an entry exists for every playlist in the api and every playlist
     * item in the playlists.
     */
    private function syncPlaylists(): void
    {
        $progress = $this->output->createProgressBar($this->playlistCount());
        $progress->start();
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
            $progress->advance();
        }
        $progress->finish();
    }

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
            ['channelId' => self::CHANNEL_ID],
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

    private function uploads(): LazyCollection
    {
        return $this->itemsInPlaylist(self::UPLOAD_PLAYLIST_ID);
    }

    private function playlistCount(): int
    {
        $response = $this->youtube->playlists->listPlaylists('id', ['channelId' => self::CHANNEL_ID]);
        return $response['pageInfo']['totalResults'] ?? 0;
    }

    private function uploadCount(): int
    {
        $response = $this->youtube->playlistItems->listPlaylistItems('id', ['playlistId' => self::UPLOAD_PLAYLIST_ID]);
        return $response['pageInfo']['totalResults'] ?? 0;
    }

    /**
     * Return a lazy collection of all of the items from all of the pages for
     * the given resource.
     */
    private function allItems(Resource $resource, string $action, string $parts, array $options): LazyCollection
    {
        return LazyCollection::make(function () use ($resource, $action, $parts, $options) {
            foreach ($this->allPages($resource, $action, $parts, $options) as $page) {
                foreach ($page['items'] as $item) {
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
            $page = $resource->{$action}($parts, $options + ['pageToken' => $nextPageToken]);
            yield $page;
            $nextPageToken = $page['nextPageToken'];
        } while ($nextPageToken);
    }
}
