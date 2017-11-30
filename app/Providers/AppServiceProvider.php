<?php

namespace App\Providers;
use Illuminate\Database\Eloquent\Relations\Relation;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMorphMap();
    }

    public function registerMorphMap()
    {
        Relation::morphMap([
            'exhibitions' => 'App\Models\Exhibition',
            'events' => 'App\Models\Event',
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
