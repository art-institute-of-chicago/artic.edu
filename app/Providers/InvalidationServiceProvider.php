<?php

namespace App\Providers;

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
        'App\Events\UpdateEvent' => [
            'App\Listeners\InvalidationListener',
        ],
        'App\Events\UpdateExhibition' => [
            'App\Listeners\InvalidationListener',
        ],
        'App\Events\UpdatePage' => [
            'App\Listeners\InvalidationListener',
        ],
        'App\Events\UpdateArticle' => [
            'App\Listeners\InvalidationListener',
        ],
        'App\Events\UpdateHomeFeature' => [
            'App\Listeners\InvalidationListener',
        ],
        'App\Events\UpdateHighlight' => [
            'App\Listeners\InvalidationListener',
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
    }
}
