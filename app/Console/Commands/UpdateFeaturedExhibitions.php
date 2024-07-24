<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiRelation;
use App\Models\Api\Exhibition;
use App\Models\Page;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class UpdateFeaturedExhibitions extends Command
{
    protected $signature = 'exhibitions:featured';

    protected $description = 'Update the current exhibitions list when upcoming exhibitions are active';

    public function handle()
    {
        $updatedExhibitions = [];

        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();

        $currentExhibitions = $page->exhibitionsCurrent->sortBy('pivot.position');
        $upcomingExhibitions = $page->exhibitionsUpcomingListing->sortBy('pivot.position');

        // Move the upcoming exhibitions to the current exhibitions list if they are now open
        $upcomingExhibitions->each(function ($exhibition) use (&$currentExhibitions, &$updatedExhibitions) {
            $id = ApiRelation::find($exhibition->pivot->api_relation_id)->datahub_id;
            $exhibitionInstance = Exhibition::query()->find($id);

            if ($exhibitionInstance->getIsNowOpenAttribute(ignoreDateDisplayOverride: true) || $exhibitionInstance->is_ongoing) {
                $this->info("Moving {$exhibitionInstance->id}: {$exhibitionInstance->title} to current exhibitions list");
                $currentExhibitions->splice(2, 0, [$exhibition]);
                $exhibition->pivot->relation = 'exhibitionsCurrent';
                $exhibition->pivot->api_relation_id = $exhibition->id;
                $exhibition->pivot->save();

                $updatedExhibitions[] = ['title' => $exhibitionInstance->title, 'status' => 'Opened'];
            }
        });

        $currentExhibitions = $currentExhibitions->reject(function ($exhibition) use (&$updatedExhibitions) {
            $id = ApiRelation::find($exhibition->pivot->api_relation_id)->datahub_id;
            $exhibitionInstance = Exhibition::query()->find($id);

            if ($exhibitionInstance->is_closed) {
                $this->info("Removing {$exhibitionInstance->id}: {$exhibitionInstance->title} from current exhibitions list");
                ApiRelation::find($exhibition->pivot->api_relation_id)->delete();

                $updatedExhibitions[] = ['title' => $exhibitionInstance->title, 'status' => 'Closed'];

                return true;
            }
            return false;
        });


        // Update the positions of the current exhibitions
        foreach ($currentExhibitions as $index => $exhibition) {
            $exhibition->pivot->position = $index + 1;
            $exhibition->pivot->save();
        }

        // Update the positions of the upcoming exhibitions
        foreach ($upcomingExhibitions as $index => $exhibition) {
            $exhibition->pivot->position = $index + 1;
            $exhibition->pivot->save();
        }

        $page->update([
            'exhibitionsCurrent' => $currentExhibitions,
            'exhibitionsUpcomingListing' => $upcomingExhibitions,
        ]);

        if (count($updatedExhibitions) === 0) {
            $this->info('No exhibitions were updated');
            return;
        }

        $emailContent = "Updated exhibitions:\n\n" . implode("\n", array_map(function ($exhibition) {
            return "{$exhibition['title']} - {$exhibition['status']}";
        }, $updatedExhibitions));

        $emailContent .= "\n\n" . Artisan::call('inspire');

        if (!config('aic.exhibition_update_recipients')) {
            $this->info('No recipients configured for exhibition updates');
        } else {
            Mail::raw($emailContent, function ($message) {
                $recipients = explode(',', config('aic.exhibition_update_recipients'));
                foreach ($recipients as $recipient) {
                    $message->to($recipient);
                }
                $message->subject('Exhibition Updates');
            });
        }
    }
}
