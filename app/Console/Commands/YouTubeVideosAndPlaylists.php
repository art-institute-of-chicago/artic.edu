<?php

namespace App\Console\Commands;

use App\Models\Playlist;
use App\Models\Video;
use App\Services\YouTube\YouTubeService;
use Illuminate\Support\Collection;

class YouTubeVideosAndPlaylists extends AbstractYoutubeCommand
{
    protected $signature = 'youtube:videos-and-playlists';
    protected $aliases = ['youtube:import'];
    protected $description = 'Import video and playlist data from YouTube';

    public function handleCommand()
    {
        $this->info('Importing uploads');
        $sourceIds = $this->importUploads();

        $this->info('Updating videos');
        $this->updateVideos($sourceIds);

        $this->info('Indicating shorts');
        $this->indicateShorts();

        $this->info('Syncing playlists');
        $this->syncPlaylists();
    }

    /**
     * Ensure a video entry exists for every item in the uploads playlist.
     */
    private function importUploads(): Collection
    {
        $progress = !$this->output->isDebug() ? $this->output->createProgressBar($this->youtube->uploadCount()) : null;
        $progress?->start();
        $sourceIds = collect();
        foreach ($this->youtube->uploads(fields: 'items/snippet(resourceId/videoId,title)') as $upload) {
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
        !$this->output->isDebug() ? $this->newLine() : null;

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
        $fields = 'items(' .
            'id,' .
            'contentDetails(caption,duration),' .
            'snippet(title,description,publishedAt,thumbnails/high/url)' .
        ')';
        foreach ($sourceIds->chunk(YouTubeService::ITEMS_PER_REQUEST) as $chunkOfSourceIds) {
            $sourceVideos = $this->youtube->videosByIds($chunkOfSourceIds, $fields);
            foreach ($sourceVideos as $source) {
                $video = Video::firstWhere('youtube_id', $source['id'])->fill([
                    'title' => $source['snippet']['title'],
                    'description' => $source['snippet']['description'],
                    'uploaded_at' => $source['snippet']['publishedAt'],
                    'duration' => $this->convertDuration($source['contentDetails']['duration']),
                    'thumbnail_url' => $source['snippet']['thumbnails']['high']['url'],
                    'is_captioned' => $source['contentDetails']['caption'],
                ]);
                $video->save();
                $progress?->advance();
            }
        }
        $progress?->finish();
        !$this->output->isDebug() ? $this->newLine() : null;
    }

    /**
     * Set entries corresponding with items from the shorts playlist as shorts.
     */
    private function indicateShorts(): void
    {
        $progress = !$this->output->isDebug() ? $this->output->createProgressBar($this->youtube->shortsCount()) : null;
        $progress?->start();
        $fields = 'items/snippet/resourceId/videoId';
        $sourceIds = $this->youtube->shorts($fields)->pluck('snippet.resourceId.videoId')->all();
        Video::whereIn('youtube_id', $sourceIds)->update(['is_short' => true]);
        $progress?->finish();
        !$this->output->isDebug() ? $this->newLine() : null;
    }

    /**
     * Ensure an entry exists for every playlist in the api and every playlist
     * item in the playlists.
     */
    private function syncPlaylists(): void
    {
        $progress = !$this->output->isDebug() ?
            $this->output->createProgressBar($this->youtube->playlistCount()) :
            null;
        $progress?->start();
        foreach ($this->youtube->playlists(fields: 'items(id,snippet(title,thumbnails/high/url))') as $sourcePlaylist) {
            $playlistId = $sourcePlaylist['id'];
            $playlist = Playlist::updateOrCreate(
                ['youtube_id' =>  $playlistId],
                [
                    'youtube_id' =>  $playlistId,
                    'title' => $sourcePlaylist['snippet']['title'],
                    'thumbnail_url' => $sourcePlaylist['snippet']['thumbnails']['high']['url'],
                ],
            );
            $fields = 'items(id,snippet(resourceId/videoId,position))';
            $sourcePlaylistItems = $this->youtube->itemsInPlaylist($playlistId, $fields)->all();
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
        !$this->output->isDebug() ? $this->newLine() : null;
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
}
