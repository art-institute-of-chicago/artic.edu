<?php

namespace App\Console\Commands;

use App\Models\Caption;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;

class YouTubeCaptions extends AbstractYoutubeCommand
{
    protected $signature = 'youtube:captions
        {--D|downloads-only : Skip importing new caption data, only download known captions}';
    protected $description = 'Download video captions from YouTube';

    protected function handleCommand()
    {
        if (!$this->option('downloads-only')) {
            $this->info('Import captions');
            $this->importCaptions();
        }

        $this->info('Download caption text');
        $this->downloadCaptionText();
    }

    /**
     * For every uncaptioned, uploaded video, create records for each
     * caption by language.
     */
    private function importCaptions(): void
    {
        $this->youtube->setMetadataFields('kind');
        $uncaptionedVideos = Video::published()
            ->whereNotNull('uploaded_at')
            ->where('is_captioned', true)
            ->whereNotIn('id', Caption::select('video_id')->where('kind', 'standard'))
            ->latest('uploaded_at');
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
                    ['kind' => $source['snippet']['trackKind']],
                    [
                        'kind' => $source['snippet']['trackKind'],
                        'updated_at' => $source['snippet']['lastUpdated'],
                    ],
                );
                $caption->translations()->updateOrCreate(
                    ['youtube_id' => $source['id']],
                    [
                        'active' => true,
                        'locale' => $source['snippet']['language'],
                        'name' => $source['snippet']['name'],
                        'youtube_id' => $source['id'],
                    ],
                );
                $progress?->advance();
            }
        }
        $progress?->finish();
        !$this->output->isDebug() ? $this->newLine() : null;
    }

    /**
     * Download the caption files for each caption missing text.
     */
    public function downloadCaptionText(): void
    {
        $captionsMissingText = Caption::where('kind', 'standard')
            ->whereHas('translations', function (Builder $query) {
                $query->whereNull('file');
            })
            ->latest('updated_at');
        $progress = !$this->output->isDebug() ?
            $this->output->createProgressBar($captionsMissingText->count()) :
            null;
        $progress?->start();
        foreach ($captionsMissingText->get() as $caption) {
            foreach ($caption->translations as $translation) {
                $file = $this->youtube->downloadCaptionById($translation->youtube_id);
                $file = str_replace("\xEF\xBB\xBF", '', $file); // Remove BOM
                $file = iconv('UTF-8', 'UTF-8//IGNORE', $file); // Remove uknown characters
                $translation->file = $file;
                $translation->save();
            }
            $progress?->advance();
        }
        $progress?->finish();
        !$this->output->isDebug() ? $this->newLine() : null;
    }
}
