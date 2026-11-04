<?php

namespace App\Console\Commands;

use App\Models\Playlist;
use App\Models\Video;
use App\Services\YouTube\YouTubeService;
use Illuminate\Support\Collection;
use Carbon\CarbonInterval;

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
     *
     * Existing entries are left untouched here, as they are updated in
     * `updateVideos`. Saving a video triggers Twill's slug handling, so avoid
     * saving videos that have not changed.
     */
    private function importUploads(): Collection
    {
        $progress = !$this->output->isDebug() ? $this->output->createProgressBar($this->youtube->uploadCount()) : null;
        $progress?->start();
        $existingIds = Video::withoutGlobalScopes()->withTrashed()->pluck('youtube_id')->flip();
        $sourceIds = collect();
        $deletedIds = collect();
        $fields = 'items(status,snippet(resourceId/videoId,title,description))';
        foreach ($this->youtube->uploads($fields) as $upload) {
            $videoId = $upload['snippet']['resourceId']['videoId'];
            if (!$existingIds->has($videoId)) {
                Video::create([
                    'youtube_id' => $videoId,
                    'title' => $this->normalizeTitle($upload['snippet']['title']),
                    'description' => $upload['snippet']['description'],
                ]);
                $existingIds->put($videoId, true);
            }
            if (
                $upload['snippet']['title'] == 'Deleted video'
                && $upload['snippet']['description'] == 'This video is unavailable.'
            ) {
                $deletedIds->push($videoId);
            } else {
                $sourceIds->push($videoId);
            }
            $progress?->advance();
        }
        // Mark deleted videos as such in the db.
        if ($deletedIds->isNotEmpty()) {
            Video::withoutGlobalScopes()->whereIn('youtube_id', $deletedIds)->delete();
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
            'snippet(title,description,publishedAt,thumbnails),' .
            'status/privacyStatus' .
        ')';
        foreach ($sourceIds->chunk(YouTubeService::ITEMS_PER_REQUEST) as $chunkOfSourceIds) {
            $sourceVideos = $this->youtube->videosByIds($chunkOfSourceIds, $fields);
            $videos = Video::withoutGlobalScopes()
                ->withTrashed()
                ->whereIn('youtube_id', $chunkOfSourceIds)
                ->get()
                ->keyBy('youtube_id');
            foreach ($sourceVideos as $source) {
                $progress?->advance();
                $video = $videos->get($source['id']);
                if (!$video) {
                    continue;
                }
                if ($source['status']['privacyStatus'] !== 'public') {
                    // Remove private and unlisted videos
                    if (!$video->trashed()) {
                    $video->delete();
                    }
                    continue;
                } elseif ($video->trashed()) {
                    $video->restore();
                }
                $thumbnail = $this->highestResolutionThumbnail($source['snippet']['thumbnails']);
                $video->fill([
                    'title' => $this->normalizeTitle($source['snippet']['title']),
                    'description' => $source['snippet']['description'],
                    'uploaded_at' => $source['snippet']['publishedAt'],
                    'duration' => $this->convertDuration($source['contentDetails']['duration']),
                    'duration_display' => $this->convertDurationDisplay($source['contentDetails']['duration']),
                    'thumbnail_url' => $thumbnail['url'],
                    'thumbnail_height' => $thumbnail['height'],
                    'thumbnail_width' => $thumbnail['width'],
                    // The api returns the caption status as the string 'true' or 'false'
                    'is_captioned' => filter_var($source['contentDetails']['caption'], FILTER_VALIDATE_BOOLEAN),
                    'privacy' => $source['status']['privacyStatus'],
                ]);
                if ($video->isDirty()) {
                    $video->save();
                }
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
        Video::withoutGlobalScopes()->whereIn('youtube_id', $sourceIds)->update(['is_short' => true]);
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
        foreach ($this->youtube->playlists(fields: 'items(id,snippet(title,thumbnails,publishedAt))') as $sourcePlaylist) {
            $playlistId = $sourcePlaylist['id'];
            $thumbnail = $this->highestResolutionThumbnail($sourcePlaylist['snippet']['thumbnails']);
            $playlist = Playlist::updateOrCreate(
                ['youtube_id' =>  $playlistId],
                [
                    'youtube_id' =>  $playlistId,
                    'title' => $sourcePlaylist['snippet']['title'],
                    'thumbnail_url' => $thumbnail['url'],
                    'thumbnail_height' => $thumbnail['height'],
                    'thumbnail_width' => $thumbnail['width'],
                    'published_at' => $sourcePlaylist['snippet']['publishedAt'],
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
    private function convertDurationDisplay(string $durationSpec): string
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

    /**
     * Convert a duration from 'PT1H1M1S' to seconds
     */
    private function convertDuration(string $durationSpec): string
    {
        return CarbonInterval::make($durationSpec)->totalSeconds;
    }

    /**
     * Retrieve the highest resolution thumbnail of those provided.
     */
    private function highestResolutionThumbnail($thumbnails): array
    {
        $resolutions = ['maxres', 'standard', 'high'];
        foreach ($resolutions as $resolution) {
            if (isset($thumbnails[$resolution])) {
                return (array) $thumbnails[$resolution];
            }
        }
        return ['url' => null, 'height' => null, 'width' => null];
    }

    /**
     * Remove title suffix from Shorts.
     */
    private function normalizeTitle(string $title): string
    {
        return str($title)->before(' | Art Institute Shorts')->toString();
    }
}
