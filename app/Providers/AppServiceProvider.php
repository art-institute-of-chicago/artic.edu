<?php

namespace App\Providers;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Libraries\Api\Consumers\GuzzleApiConsumer;

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
        $this->composeTemplatesViews();
    }

    public function registerMorphMap()
    {
        Relation::morphMap([
            'events' => 'App\Models\Event',
            'articles' => 'App\Models\Article',
            'selections' => 'App\Models\Selection',
            'artists' => 'App\Models\Artist'
        ]);
    }

    public function registerApiClient()
    {
        $this->app->singleton('ApiClient', function($app)
        {
            return new GuzzleApiConsumer([
                'base_uri'   => config('api.base_uri'),
                'exceptions' => false
            ]);
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

    private function composeTemplatesViews()
    {
      view()->composer('layouts.*', function ($view) {
        $view->with([
            'mobileNav' => [
                [
                    'name' => 'Visit',
                    'children' => [
                        [
                            'name' => 'Plan Your Visit',
                        ],
                        [
                            'name' => 'Museum Spaces',
                        ],
                        [
                            'name' => 'Group Visits',
                            'children' => [
                                [
                                    'name' => 'Adults &amp; Universities',
                                    'slug' => '#',
                                ],
                                [
                                    'name' => 'Students',
                                    'children' => [
                                        [
                                            'name' => 'Tours',
                                            'slug' => '#'
                                        ],
                                        [
                                            'name' => 'Scheduling a Tour',
                                            'slug' => '#',
                                        ],
                                        [
                                            'name' => 'Preparing For a Museum Visit',
                                            'slug' => '#',
                                        ],
                                        [
                                            'name' => 'Bus Scholarship',
                                            'slug' => '#',
                                        ],
                                        [
                                            'name' => 'Students with Disabilities',
                                            'slug' => '#',
                                        ],
                                        [
                                            'name' => 'For Tour Companies',
                                            'slug' => '#',
                                        ],
                                    ]
                                ],
                                [
                                    'name' => 'Groups FAQs',
                                    'slug' => '#',
                                ],
                            ],
                        ],
                        [
                            'name' => 'Families',
                        ],
                        [
                            'name' => 'Accessibility &amp; FAQs',
                        ],
                        [
                            'name' => 'Maps &amp; Guides',
                        ],
                    ],
                ],
                [
                    'name' => 'Exhibition &amp; Events',
                    'slug' => '#',
                ],
                [
                    'name' => 'The Collection',
                    'children' => [
                        [
                            'name' => 'Lorem Ipsum',
                        ],
                    ],
                ],
                [
                    'name' => 'Buy Tickets',
                    'slug' => '#',
                ],
                [
                    'name' => 'Become A Member',
                    'slug' => '#',
                ],
                [
                    'name' => 'Shop',
                    'slug' => '#',
                ],
                [
                    'name' => 'About Us',
                    'slug' => '#',
                    'class' => 'g-nav-mobile__nav--muted',
                ],
                [
                    'name' => 'Learn With Us',
                    'slug' => '#',
                    'class' => 'g-nav-mobile__nav--muted',
                ],
                [
                    'name' => 'Support Us',
                    'slug' => '#',
                    'class' => 'g-nav-mobile__nav--muted',
                ],
            ]
        ]);
      });
    }
}
