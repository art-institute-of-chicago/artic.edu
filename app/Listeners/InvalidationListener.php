<?php

namespace App\Listeners;

use App\Events\UpdateEvent;
use Illuminate\Support\Facades\Artisan;

class InvalidationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  UpdateEvent  $event
     * @return void
     */
    public function handle($event)
    {
        Artisan::call('cache:invalidate-cdn', ['urls' => $event->urls]);
    }
}
