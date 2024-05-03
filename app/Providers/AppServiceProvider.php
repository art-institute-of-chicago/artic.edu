<?php

namespace App\Providers;

use A17\Twill\Http\Controllers\Front\Helpers\Seo;
use A17\Twill\Models\File;
use App\Models\Hour;
use App\Libraries\Api\Consumers\GuzzleApiConsumer;
use App\Libraries\EmbedConverterService;
use App\Libraries\DamsImageService;
use App\Observers\FileObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->hotfixSeoForAdminPreview();

        $this->registerMorphMap();
        $this->registerApiClient();
        $this->registerDamsImageService();
        $this->registerEmbedConverterService();
        $this->registerClosureService();
        $this->registerPrintService();
        $this->composeTemplatesViews();
        File::observe(FileObserver::class);

        \Illuminate\Pagination\AbstractPaginator::defaultView('site.pagination.aic');
        \Illuminate\Pagination\AbstractPaginator::defaultSimpleView('site.pagination.simple-aic');
    }

    /**
     * Taken from Front/Controller. Figure out how to make this affect Twill's ModuleController
     */
    private function hotfixSeoForAdminPreview(): void
    {
        $seo = new Seo();

        $seo->title = config('twill.seo.site_title');
        $seo->description = config('twill.seo.site_desc');
        $seo->image = config('twill.seo.image');
        $seo->width = config('twill.seo.width');
        $seo->height = config('twill.seo.height');

        \View::share('seo', $seo);
    }

    public function registerMorphMap(): void
    {
        Relation::morphMap([
            'events' => 'App\Models\Event',
            'articles' => 'App\Models\Article',
            'highlights' => 'App\Models\Highlight',
            'artists' => 'App\Models\Artist',
            'homeFeatures' => 'App\Models\HomeFeature',
            'landingPages' => 'App\Models\LandingPage',
            'genericPages' => 'App\Models\GenericPage',

            'experiences' => 'App\Models\Experience',

            'digitalPublications' => 'App\Models\DigitalPublication',
            'digitalPublicationSections' => 'App\Models\DigitalPublicationSection',
            'magazineIssues' => 'App\Models\MagazineIssue',
            'pressReleases' => 'App\Models\PressRelease',
            'printedPublications' => 'App\Models\PrintedPublication',
            'researchGuides' => 'App\Models\ResearchGuide',
            'sponsors' => 'App\Models\Sponsor',

            'educatorResources' => 'App\Models\EducatorResource',
            'videos' => 'App\Models\Video',
            'exhibitions' => 'App\Models\Exhibition',
            'exhibitionPressRooms' => 'App\Models\ExhibitionPressRoom',
            'departments' => 'App\Models\Department',
            'blocks' => 'App\Models\Vendor\Block',
        ]);
    }

    public function registerApiClient(): void
    {
        $this->app->singleton('ApiClient', function ($app) {
            return new GuzzleApiConsumer([
                'base_uri' => config('api.base_uri'),
                'exceptions' => false,
                'decode_content' => true, // Explicit default
            ]);
        });
    }

    public function registerEmbedConverterService(): void
    {
        $this->app->singleton('embedconverterservice', function ($app) {
            return new EmbedConverterService();
        });
    }

    public function registerDamsImageService(): void
    {
        $this->app->singleton('damsimageservice', function ($app) {
            return new DamsImageService();
        });
    }

    public function registerClosureService(): void
    {
        $this->app->singleton('closureservice', function ($app) {
            return new class () {
                private $checkedForClosure = false;

                private $cachedClosure;

                public function getClosure()
                {
                    if (!$this->checkedForClosure) {
                        $this->cachedClosure = \App\Models\BuildingClosure::today()->first();
                        $this->checkedForClosure = true;
                    }

                    return $this->cachedClosure;
                }
            };
        });
    }

    public function registerPrintService(): void
    {
        $this->app->singleton('printservice', function ($app) {
            return new class () {
                private $isPrintMode;

                public function __construct()
                {
                    $this->isPrintMode = isset($_GET['print']);
                }

                public function isPrintMode()
                {
                    return $this->isPrintMode;
                }
            };
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        config(['aic.version' => trim(file_get_contents(__DIR__ . '/../../VERSION'))]);
    }

    private function composeTemplatesViews()
    {
        if (!\Schema::hasTable('hours')) {
            /*
            If the project is being initialized or not all of the migrations
            have been run yet, the `hours` table may not exist, so skip this
            function.
            */
            return;
        }
        $hour = app()->environment() === 'testing' ? null : Hour::today()->first();

        // WEB-2269: Consider moving some of this to a config?
        view()->composer('*', function ($view) use ($hour) {
            $view->with([
                'hour' => $hour,
                '_pages' => [
                    'visit' => route('pages.slug', ['slug' => 'visit']),
                    'hours' => route('pages.slug', ['slug' => 'visit']) . '#hours',
                    'directions' => route('pages.slug', ['slug' => 'visit']) . '#directions',
                    'buy' => 'https://sales.artic.edu/admissions',
                    'become-a-member' => 'https://sales.artic.edu/memberships',
                    'shop' => 'https://shop.artic.edu/',
                    'collection' => route('collection'),
                    'exhibitions' => route('exhibitions'),
                    'events' => route('events'), 'about-us' => '/about-us',
                    'about-us-mission-and-history' => '/about-us/mission-and-history',
                    'about-us-leadership' => '/about-us/leadership',
                    'about-us-departments' => '/about-us/departments',
                    'about-us-financial-reporting' => '/about-us/financial-reporting',
                    'support-us' => '/support-us',
                    'support-us-membership' => '/support-us/membership',
                    'support-us-luminary' => '/support-us/membership/luminary-levels',
                    'support-us-planned-giving' => '/support-us/ways-to-give/planned-giving',
                    'support-us-corporate-sponsorship' => '/support-us/ways-to-give/corporate-sponsorship',
                    'learn' => '/learn-with-us',
                    'learn-families' => '/learn-with-us/families',
                    'learn-teens' => '/learn-with-us/teens',
                    'learn-adults' => '/visit/whos-visiting/college-and-university-groups-2',
                    'learn-educators' => '/learn-with-us/educators',
                    'learn-rlc' => '/ryan-learning-center',
                    'follow-facebook' => 'https://www.facebook.com/artic',
                    'follow-twitter' => 'https://twitter.com/artinstitutechi',
                    'follow-instagram' => 'https://www.instagram.com/artinstitutechi/',
                    'follow-youtube' => 'https://www.youtube.com/user/ArtInstituteChicago',
                    'legal-articles' => route('articles'),
                    'legal-employment' => '/employment',
                    'legal-venue-rental' => '/venue-rental',
                    'legal-contact' => '/contact', 'legal-press' => '/press',
                    'legal-terms' => '/terms',
                    'legal-image-licensing' => '/image-licensing',
                    'legal-saic' => 'https://www.saic.edu',
                ],
                'primaryNav' => [
                    [
                        'name' => 'Visit',
                        'description' => 'Find all the information you need&mdash;plus helpful tips&mdash;to plan your visit',
                        'cta' => 'Start planning',
                        'image' => 'https://artic-web.imgix.net/b55a24a5-ab1c-453e-9ecd-e30ee5473f6e/navigation-thumbnail-visit.jpg',
                        'url' => route('pages.slug', ['slug' => 'visit']),
                        'children' => [
                            [
                                'name' => 'Hours',
                                'url' => route('pages.slug', ['slug' => 'visit']) . '#hours',
                            ],
                            [
                                'name' => 'Admission',
                                'url' => route('pages.slug', ['slug' => 'visit']) . '#admission',
                            ],
                            [
                                'name' => 'Plan Your Visit',
                                'url' => route('pages.slug', ['slug' => 'visit']) . '#plan-your-visit',
                                'children' => [
                                    [
                                        'name' => 'Museum Map',
                                        'url' => '/visit/explore-on-your-own/museum-floor-plan',
                                    ],
                                    [
                                        'name' => 'Free Daily Tours',
                                        'url' => route('events', ['audience' => 3, 'type' => 6]),
                                    ],
                                    [
                                        'name' => 'My Museum Tour',
                                        'url' => route('pages.slug', ['slug' => 'my-museum-tour']),
                                    ],
                                    [
                                        'name' => 'What to See in an Hour',
                                        'url' => route('highlights.show', ['id' => 3, 'slug' => 'what-to-see-in-an-hour']),
                                    ],
                                    [
                                        'name' => 'Shopping and Dining',
                                        'url' => '/visit/dining-and-shopping',
                                    ],
                                    [
                                        'name' => 'Accessibility',
                                        'url' => '/visit/accessibility',
                                    ],
                                ],
                            ],
                            [
                                'name' => 'Who&apos;s Visiting?',
                                'url' => route('pages.slug', ['slug' => 'visit']) . '#whos-visiting',
                                'children' => [
                                    [
                                        'name' => 'First-Time Visitors',
                                        'url' => '/visit/whos-visiting/first-time-visitors',
                                    ],
                                    [
                                        'name' => 'Families',
                                        'url' => '/visit/whos-visiting/families-2',
                                    ],
                                    [
                                        'name' => 'Members',
                                        'url' => '/visit/whos-visiting/members',
                                    ],
                                    [
                                        'name' => 'Teens',
                                        'url' => '/visit/whos-visiting/teens-2',
                                    ],
                                    [
                                        'name' => 'Educators',
                                        'url' => '/visit/whos-visiting/educators-2',
                                    ],
                                    [
                                        'name' => 'Group Visits',
                                        'url' => '/visit/whos-visiting/adult-groups-2',
                                    ],
                                ],
                            ],
                            [
                                'name' => 'Mobile App',
                                'url' => '/visit/explore-on-your-own/mobile-app-audio-tours',
                            ],
                            [
                                'name' => 'Ryan Learning Center',
                                'url' => '/ryan-learning-center',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Exhibitions',
                        'url' => route('exhibitions'),
                        'class' => 'exhibitions',
                        'children' => [
                            [
                                'name' => 'Current',
                                'url' => route('exhibitions'),
                            ],
                            [
                                'name' => 'Upcoming',
                                'url' => route('exhibitions.upcoming'),
                            ],
                            [
                                'name' => 'Archive',
                                'url' => route('exhibitions.history'),
                            ],
                        ],
                    ],
                    [
                        'name' => 'Art &amp; Artists',
                        'description' => 'Explore the works in our collection and delve deeper into their stories.',
                        'cta' => 'Start your discovery',
                        'image' => 'https://artic-web.imgix.net/fd36787d-a4f7-480c-8e34-11115a9d240a/navigation-thumbnail-art-and-artists.jpg',
                        'url' => route('collection'),
                        'children' => [
                            [
                                'name' => 'Artworks',
                                'url' => route('collection'),
                            ],
                            [
                                'name' => 'Articles &amp; Videos',
                                'url' => route('pages.slug', ['slug' => 'articles-and-videos']),
                            ],
                            [
                                'name' => 'Research',
                                'url' => route('collection.research_resources'),
                                'children' => [
                                    [
                                        'name' => 'Library',
                                        'url' => '/library',
                                    ],
                                    [
                                        'name' => 'Archival Collections',
                                        'url' => '/archival-collections',
                                    ],
                                    [
                                        'name' => 'Collection Information',
                                        'url' => '/collection-information',
                                    ],
                                    [
                                        'name' => 'Conservation and Science',
                                        'url' => '/about-us/departments/conservation-and-science-2',
                                    ],
                                ],
                            ],
                            [
                                'name' => 'Publications',
                                'url' => route('articles_publications'),
                                'children' => [
                                    [
                                        'name' => 'Print Catalogues',
                                        'url' => route('collection.publications.printed-publications'),
                                    ],
                                    [
                                        'name' => 'Digital Publications',
                                        'url' => route('collection.publications.digital-publications'),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'name' => 'Events',
                        'description' => 'Join us for a wide range of programs&mdash;there&apos;s something for visitors of all ages.',
                        'cta' => 'Check out the calendar',
                        'image' => 'https://artic-web.imgix.net/d335c986-7075-4753-a84f-9cb11876ac77/navigation-thumbnail-events.jpg',
                        'url' => route('events'),
                        'children' => [
                            [
                                'name' => 'Calendar',
                                'url' => route('events'),
                            ],
                            [
                                'name' => 'Daily Tours',
                                'url' => route('events', ['type' => 6]),
                            ],
                            [
                                'name' => 'Talks',
                                'url' => route('events', ['type' => 5]),
                            ],
                            [
                                'name' => 'Art Making',
                                'url' => route('events', ['type' => 1]),
                            ],
                            [
                                'name' => 'Member Programs',
                                'url' => route('events', ['audience' => 2]),
                            ],
                        ],
                    ],
                    [
                        'name' => 'Become a Member',
                        'class' => 'u-hide@small+',
                        'url' => 'https://sales.artic.edu/memberships',
                    ],
                ],
                'secondaryNav' => [
                    [
                        'name' => 'Buy Tickets',
                        'url' => 'https://sales.artic.edu/admissions',
                    ],
                    [
                        'name' => 'Become a Member',
                        'class' => 'u-show@small+',
                        'url' => 'https://sales.artic.edu/memberships',
                    ],
                    [
                        'name' => 'Shop',
                        'class' => 'u-show@small+',
                        'url' => 'https://shop.artic.edu/',
                    ],
                    [
                        'name' => 'Visit',
                        'class' => 'u-hide@small+',
                        'url' => route('pages.slug', ['slug' => 'visit']),
                    ],
                ],
            ]);
        });
    }
}
