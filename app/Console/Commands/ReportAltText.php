<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
            \App\Models\DigitalPublication::class,
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
            \App\Models\PrintedPublication::class,
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
                    $medias[] = $item->medias->map(function($media) use ($item) {
                        return [
                            (string) $media->id => [
                                'alt_text' => $media->alt_text,
                                'uuid' => $media->uuid,
                                'filename' => $media->filename,
                                'url' => $this->url($item)
                            ]
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
        foreach ($medias as $id => $props) {
            $out[] = [
                'image_url' => 'https://' . config('twill.imgix_source_host') .'/' .$props['uuid'],
                'alt_text' => $props['alt_text'],
                'on_page' => $props['url'],
                'id' => $id,
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

    /**
     * Determine URL for a givel model.
     *
     * @TODO: Should `url` be a model property? Most URLs in the system are
     * determined by Laravel's routing system, in contexts where the type of
     * model is known, and therefore so is the route's name alias to use. So
     * perhaps this context unusual, where we don't actually know the type
     * of object we're determining a URL for. More to think on.
     */
    function url($item) {
        $prefix = $this->pathPrefix($item);
        $slug = $item->idSlug;

        // Alter prefixes
        if (\App\Models\DigitalPublication::class == get_class($item)) {
            $prefix = 'digital-publications';
        }
        if (\App\Models\PrintedPublication::class == get_class($item)) {
            $prefix = 'print-publications';
        }
        if (\App\Models\EducatorResource::class == get_class($item)) {
            $prefix = 'collection/resources/educator-resources';
        }
        if (\App\Models\ExhibitionPressRoom::class == get_class($item)) {
            $prefix = 'press/exhibition-press-room';
        }
        if (\App\Models\PressRelease::class == get_class($item)) {
            $prefix = 'press/press-releases';
        }
        if (\App\Models\Selection::class == get_class($item)) {
            $prefix = 'highlights';
        }

        // Alter slugs
        if (\App\Models\Artist::class == get_class($item)
            || \App\Models\Department::class == get_class($item)
            || \App\Models\Exhibition::class == get_class($item)) {
            $slug = $item->datahub_id .'/' .$item->getApiModelFilled()->titleSlug;
        }
        if (\App\Models\GenericPage::class == get_class($item)) {
            return 'https://www.artic.edu' .$item->url;
        }
        if (\App\Models\CategoryTerm::class == get_class($item)) {
            if ($item->local_subtype == 'style') {
                return 'https://www.artic.edu/collection?style_ids=' .urlencode($item->local_title);
            }
            if ($item->local_subtype == 'subject') {
                return 'https://www.artic.edu/collection?subject_ids=' .urlencode($item->local_title);
            }
            if ($item->local_subtype == 'classification') {
                return 'https://www.artic.edu/collection?classification_ids=' .urlencode($item->local_title);
            }
            if ($item->local_subtype == 'theme') {
                return 'https://www.artic.edu/collection?theme_ids=' .urlencode($item->datahub_id);
            }
        }
        if (\App\Models\HomeFeature::class == get_class($item)) {
            return 'https://www.artic.edu';
        }
        if (\App\Models\Page::class == get_class($item)) {
            if ($item->id == 1) {
                return 'https://www.artic.edu/collection/research_resources';
            }
            if ($item->id == 2) {
                return 'https://www.artic.edu/articles_publications';
            }
            if ($item->id == 3) {
                return 'https://www.artic.edu';
            }
            if ($item->id == 4) {
                return 'https://www.artic.edu/exhibitions';
            }
            if ($item->id == 5) {
                return 'https://www.artic.edu/collection';
            }
            if ($item->id == 6) {
                return 'https://www.artic.edu/visit';
            }
            if ($item->id == 7) {
                return 'https://www.artic.edu/articles';
            }
            if ($item->id == 8) {
                return 'https://www.artic.edu/exhibitions/history';
            }
            if ($item->id == 9) {
                return 'https://www.artic.edu/collection';
            }
        }

        if (\A17\Twill\Models\Block::class == get_class($item)
            || \App\Models\Lightbox::class == get_class($item)) {
            return '';
        }

        return 'https://www.artic.edu/' .$prefix .'/'. $slug;
    }

    function pathPrefix($item) {
        return Str::plural(strtolower(class_basename(get_class($item))));
    }
}
