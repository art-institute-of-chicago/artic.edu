<?php

namespace App\Console\Commands;

use App\Models\Caption;
use App\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class YouTubeCaptions extends AbstractYoutubeCommand
{
    protected $signature = 'youtube:captions
        {--D|downloads-only : Skip importing new caption data, only download known captions}';
    protected $description = 'Download video captions from YouTube';

    protected function handleCommand()
    {
        if (!$this->option('downloads-only')) {
            $this->info('Check for updated captions');
            $this->updateExistingCaptions();
            $this->info('Import new captions');
            $this->importCaptions();
        }

        $this->info('Download caption text');
        $this->downloadCaptionText();
    }

    /**
     * For every captioned, public video, update the records for each caption
     * if they have since been update.
     */
    private function updateExistingCaptions(): void
    {
        $captionedVideos = Video::where('is_captioned', true)
            ->where('privacy', 'public')
            ->whereHas('captions', function (Builder $query) {
                $query->whereHas('translations', function (Builder $query) {
                    $query->whereNotNull('file');
                });
            })
            ->latest('uploaded_at');
        $progress = !$this->output->isDebug() ?
            $this->output->createProgressBar($captionedVideos->count()) :
            null;
        $progress?->start();
        foreach ($captionedVideos->get() as $video) {
            $fields = 'items(id,snippet(language,lastUpdated,name,trackKind))';
            $sourceCaptions = $this->youtube->captionsForVideo($video->youtube_id, $fields);
            foreach ($sourceCaptions as $source) {
                $sourceLastUpdated = Carbon::create($source['snippet']['lastUpdated']);
                if ($sourceLastUpdated->lessThanOrEqualTo($video->updated_at)) {
                    // Bypass source videos that have not been updated
                    continue;
                }
                $this->updateCaptionAndTranslation($source, $video);
                $progress?->advance();
            }
        }
        $progress?->finish();
        !$this->output->isDebug() ? $this->newLine() : null;
    }

    /**
     * For every uncaptioned, uploaded video, create records for each caption by
     * language.
     */
    private function importCaptions(): void
    {
        $uncaptionedVideos = Video::where('is_captioned', true)
            ->whereNotIn('id', Caption::select('video_id')->where('kind', 'standard'))
            ->whereNotNull('uploaded_at')
            ->latest('uploaded_at');
        $progress = !$this->output->isDebug() ?
            $this->output->createProgressBar($uncaptionedVideos->count()) :
            null;
        $progress?->start();
        foreach ($uncaptionedVideos->get() as $video) {
            $fields = 'items(id,snippet(language,lastUpdated,name,trackKind))';
            $sourceCaptions = $this->youtube->captionsForVideo($video->youtube_id, $fields);
            foreach ($sourceCaptions as $source) {
                // Only use the language code and disregard the region code,
                // if present. For example, with the code "en-US", we only care
                // about "en".
                $languageCode = substr($source['snippet']['language'], 0, 2);
                if (collect(getLocales())->doesntContain($languageCode)) {
                    // Bypass captions with languages not supported by the app
                    continue;
                }
                if ($source['snippet']['trackKind'] != 'standard') {
                    // Bypass non-standard, automated speech recognition captions
                    continue;
                }
                $this->updateCaptionAndTranslation($source, $video);
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
            ->whereHas('video', function (Builder $query) {
                $query->where('privacy', 'public');
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

    private function updateCaptionAndTranslation($source, Video $video): void
    {
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
    }
}
