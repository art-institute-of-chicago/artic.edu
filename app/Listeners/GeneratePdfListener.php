<?php

namespace App\Listeners;

use Artisan;

class GeneratePdfListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdateIssueArticle  $event
     * @return void
     */
    public function handle($event)
    {
        if (config('app.env') == 'production' || config('app.env') == 'staging')
        {
            Artisan::call('pdfs:generate-one', ['model' => get_class($event->item), 'id' => $event->item->id]);
        }
    }
}
