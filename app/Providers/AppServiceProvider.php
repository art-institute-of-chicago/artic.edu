<?php

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

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
        $this->registerApiClient();
    }

    public function registerMorphMap()
    {
        Relation::morphMap([
            'exhibitions' => 'App\Models\Exhibition',
            'events' => 'App\Models\Event',
            'articles' => 'App\Models\Article',
            'artworks' => 'App\Models\Artwork',
            'selections' => 'App\Models\Selection'
        ]);
    }

    public function registerApiClient()
    {
        $this->app->singleton('ApiClient', function($app)
        {
            return new \GuzzleHttp\Client(['base_uri' => config('api.base_uri')]);
        });
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
