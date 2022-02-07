<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Api\Artwork;
use App\Models\ExperienceImage;

class UpdateExperienceImageCredits extends Command
{
    protected $signature = 'update:experience-image-credits';

    protected $description = 'Update experience image inline credits with Data Hub data';

    public function handle()
    {
        $images = ExperienceImage::whereNotNull('object_id')->where('credits_input', '=', 'datahub')->get();

        $bar = $this->output->createProgressBar(count($images));
        $bar->start();
        foreach ($images as $image) {
            $object_id = $image->object_id;
            $apiResult = Artwork::query()->find($object_id);
            if ($apiResult instanceof Artwork) {
                $artwork = $apiResult->toArray();
                $credits_map = [
                    'artist' => 'artist_title',
                    'credit_title' => 'title',
                    'credit_date' => 'date_start',
                    'medium' => 'medium_display',
                    'dimensions' => 'dimensions',
                    'credit_line' => 'credit_line',
                    'main_reference_number' => 'main_reference_number',
                    'copyright_notice' => 'copyright_notice',
                ];
                foreach ($credits_map as $contentBundleKey => $artworkKey) {
                    $image->{$contentBundleKey} = $artwork[$artworkKey];
                }
                $image->save();
                $bar->advance();
            }
        }
        $bar->finish();
        $this->line('');
    }
}
