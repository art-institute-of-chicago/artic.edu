<?php

namespace App\Console\Commands;

use App\Models\Event;

use Illuminate\Console\Command;

class UpdateCancelled extends Command
{
    protected $signature = 'update:cancelled';

    protected $description = 'Prepend cancelled to titles of cancelled events';

    public function handle()
    {
        foreach (Event::cursor() as $event) {
            if ($event->title_display) {
                if (strpos($event->title_display, 'CANCELED') !== false) {
                    if (strpos($event->title, 'CANCELED') === false) {
                        $event->title = 'CANCELED | ' . $event->title;
                        dump($event->title, $event->title_display);
                        $event->save();
                    }
                }
            }
        }
    }
}
