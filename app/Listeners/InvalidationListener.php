<?php

namespace App\Listeners;

use App\Events\UpdateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Artisan;

class InvalidationListener
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
     * @param  UpdateEvent  $event
     * @return void
     */
    public function handle($event)
    {
        Artisan::call('cache:clear');
        Artisan::call('cache:invalidate-cloudfront', ['urls' => $event->urls]);
    }
}
