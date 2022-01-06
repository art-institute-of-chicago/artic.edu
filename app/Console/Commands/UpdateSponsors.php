<?php

namespace App\Console\Commands;

use App\Models\Exhibition;
use App\Models\Sponsor;

use A17\Twill\Repositories\BlockRepository;

use Illuminate\Console\Command;

class UpdateSponsors extends Command
{
    protected $signature = 'update:sponsors';

    protected $description = 'Migrate sponsor data from exhibition fields to the new sponsor model';

    public function handle()
    {
        // Instantiate the block repository
        $blockRepository = app(BlockRepository::class);

        // Remove all existing sponsors, including soft-deleted ones
        Sponsor::withTrashed()->where('id', '!=', 26)->get()->each(function ($sponsor) use ($blockRepository) {

            // Delete all the blocks - deleting the sponsor doesn't cascade changes
            $blockRepository->bulkDelete($sponsor->blocks()->pluck('id')->toArray());

            // Permanently delete the sponsor - cascades to event_sponsors, exhibition_sponsors
            $sponsor->forceDelete();
        });

        // Find all exhibitions with sponsor field
        $exhibitions = Exhibition::whereNotNull('sponsors_description')->where('id', '!=', 1)->get();

        foreach ($exhibitions as $exhibition) {
            // Create a new sponsor
            $sponsor = new Sponsor();
            $sponsor->title = $exhibition->title;
            $sponsor->published = $exhibition->published;
            $sponsor->save();

            // Get cleaned content
            $content = $this->getSponsorContent($exhibition->sponsors_description);

            // Generate a paragraph block for attachment
            $block = $this->getParagraphBlock($sponsor, 1, $content);

            // Create the block
            $blockRepository->create($block);

            // Attach the sponsor to the exhibition
            $exhibition->sponsors()->sync([
                $sponsor->id => [
                    'position' => 1, // 1-based
                ]
            ]);
        }
    }

    private function getParagraphBlock($model, $position, $content)
    {
        return [
            'blockable_id' => $model->id,
            'blockable_type' => $model->getMorphClass(),
            'position' => $position,
            'type' => 'paragraph',
            'content' => ['paragraph' => $content],
        ];
    }

    private function getSponsorContent($content)
    {
        // Remove <br> tags
        $content = preg_replace('/<br *\/*>/', '', $content);

        // Split by \n\n, trim, and wrap in <p>
        $paragraphs = collect(explode("\n\n", $content));

        $paragraphs = $paragraphs->map(function ($paragraph) {
            $paragraph = trim($paragraph);
            $paragraph = '<p>' . $paragraph . '</p>';

            return $paragraph;
        });

        $content = $paragraphs->implode('');

        return $content;
    }
}
