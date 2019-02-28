<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReportAltText extends Command
{

    protected $signature = 'report:alt-text';

    protected $description = 'Output all alt text info about images in use';

    public function handle()
    {
        $medias = [];

        collect([
            \App\Models\Article::class,
            \App\Models\Artist::class,
            \App\Models\CategoryTerm::class,
            \App\Models\Department::class,
            \App\Models\DigitalCatalog::class,
            \App\Models\DiningHour::class,
            \App\Models\EducatorResource::class,
            \App\Models\Event::class,
            \App\Models\Exhibition::class,
            \App\Models\ExhibitionPressRoom::class,
            \App\Models\Family::class,
            \App\Models\Gallery::class,
            \App\Models\GenericPage::class,
            \App\Models\HomeFeature::class,
            \App\Models\Lightbox::class,
            \App\Models\Offer::class,
            \App\Models\Page::class,
            \App\Models\PressRelease::class,
            \App\Models\PrintedCatalog::class,
            \App\Models\ResearchGuide::class,
            \App\Models\Selection::class,
            \App\Models\Video::class,
            \A17\Twill\Models\Block::class,
        ])->map(function($model) {
            $table = with(new $model)->getTable();
            $query = $model::whereHas('medias');
            if (\Schema::hasColumn($table, 'published')) {
                $query->published();
            }
            if (\Schema::hasColumn($table, 'deleted_at')) {
                $query->whereNull('deleted_at');
            }
            return $query->with('medias');
        })->map(function($query) use (&$medias) {
            return $query->chunk(100, function($items) use (&$medias) {
                foreach ($items as $item) {
                    $medias[] = $item->medias->map(function($media) {
                        return [
                            (string) $media->id => $media->alt_text
                        ];
                    })->all();
                }
            });
        });

        // Combine all the medias together
        $medias = array_merge(...$medias);

        // Collapse the array while preserving numeric keys
        $medias = array_reduce($medias, function ($carry, $item) { return $carry + $item; }, []);

        // At this point, everything should be deduped, since it's keyed by id
        $out = [];

        // Prep for str_putcsv()
        foreach ($medias as $id => $alt_text) {
            $out[] = [
                'id' => $id,
                'alt_text' => $alt_text,
                // TODO: Add Imgix link!
            ];
        }

        // Output the string in CSV format for output redirection
        $this->info($this->str_putcsv($out));
    }

    /**
     * Convert a multi-dimensional, associative array to CSV data
     * @link https://coderwall.com/p/zvzwwa/array-to-comma-separated-string-in-php
     * @param  array $data the array of data
     * @return string       CSV text
     */
    private function str_putcsv($data)
    {
        // Don't create a file, attempt to use memory instead
        $fh = fopen('php://temp', 'rw');

        // Write out the headers
        fputcsv($fh, array_keys(current($data)));

        // Write out the data
        foreach ( $data as $row ) {
            fputcsv($fh, $row);
        }

        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        return $csv;
    }
}
