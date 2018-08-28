<?php

namespace App\Console\Commands;

use App\Models\Event;

use Illuminate\Console\Command;

class UpdateCredits extends Command
{

    protected $signature = 'update:credits';

    protected $description = 'Clean image credits imported from old website';

    public function handle()
    {

        foreach (Event::cursor() as $event) {
            if ($event->hero_caption) {
                $event->hero_caption = strip_tags(html_entity_decode($event->hero_caption), '<p><em><i>');
                dump($event->hero_caption);
                $event->save();
            }
        };

    }

}


