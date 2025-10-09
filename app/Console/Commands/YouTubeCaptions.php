<?php

namespace App\Console\Commands;

use App\Models\Caption;
use App\Models\Video;

class YouTubeCaptions extends AbstractYoutubeCommand
{
    protected $signature = 'youtube:captions';
    protected $description = 'Download video captions from YouTube';

    protected function handleCommand()
    {
        $this->info('Downloading captions');
        $this->downloadCaptions();
    }

    /**
     * Download the caption files for each video.
     */
    private function downloadCaptions(): void
    {
        $this->youtube->setMetadataFields('kind');
        $uncaptionedVideos = Video::whereNotIn('id', Caption::distinct('video_id')->select('video_id'))
            ->whereNotNull('uploaded_at')
            ->published();
        $progress = !$this->output->isDebug() ?
            $this->output->createProgressBar($uncaptionedVideos->count()) :
            null;
        $progress?->start();
        foreach ($uncaptionedVideos->get() as $video) {
            $fields = 'items(id,snippet(language,lastUpdated,name,trackKind))';
            $sourceCaptions = $this->youtube->captionsForVideo($video->youtube_id, $fields);
            foreach ($sourceCaptions as $source) {
                if (collect(getLocales())->doesntContain($source['snippet']['language'])) {
                    // Bypass captions with languages not supported by the app
                    continue;
                }
                $caption = $video->captions()->updateOrCreate(
                    ['youtube_id' => $source['id']],
                    [
                        'youtube_id' => $source['id'],
                        'updated_at' => $source['snippet']['lastUpdated'],
                        'kind' => $source['snippet']['trackKind'],
                    ],
                );
                $caption->translations()->updateOrCreate(
                    ['locale' => $source['snippet']['language']],
                    [
                        'active' => true,
                        'locale' => $source['snippet']['language'],
                        'name' => $source['snippet']['name'],
                    ],
                );
                // TODO Download caption file
                $progress?->advance();
            }
        }
        $progress?->finish();
        !$this->output->isDebug() ? $this->newLine() : null;
    }
}
