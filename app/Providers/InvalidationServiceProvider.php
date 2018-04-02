<?php

namespace App\Providers;

use Artisan;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class InvalidationServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen([
            'eloquent.saved: App\Models\Event',
            'eloquent.deleted: App\Models\Event',
        ], function ($event) {
            Artisan::call('cache:clear');
            Artisan::call('cache:invalidate-cloudfront', ['urls' => [route('events.show', $event, false), '/']]);
        });
    }
}
