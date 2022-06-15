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
     *
     * @return void
     */
    public function boot()
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
    private function hotfixSeoForAdminPreview()
    {
        $seo = new Seo();

        $seo->title = config('twill.seo.site_title');
        $seo->description = config('twill.seo.site_desc');
        $seo->image = config('twill.seo.image');
        $seo->width = config('twill.seo.width');
        $seo->height = config('twill.seo.height');

        \View::share('seo', $seo);
    }

    public function registerMorphMap()
    {
        Relation::morphMap([
            'events' => 'App\Models\Event',
            'articles' => 'App\Models\Article',
            'highlights' => 'App\Models\Highlight',
            'artists' => 'App\Models\Artist',
            'homeFeatures' => 'App\Models\HomeFeature',

            'experiences' => 'App\Models\Experience',

            'digitalPublications' => 'App\Models\DigitalPublication',
            'printedPublications' => 'App\Models\PrintedPublication',

            'educatorResources' => 'App\Models\EducatorResource',
            'videos' => 'App\Models\Video',
            'exhibitions' => 'App\Models\Exhibition',
            'departments' => 'App\Models\Department',
            'blocks' => 'App\Models\Vendor\Block',

            'issueArticles' => 'App\Models\IssueArticle',
        ]);
    }

    public function registerApiClient()
    {
        $this->app->singleton('ApiClient', function ($app) {
            return new GuzzleApiConsumer([
                'base_uri' => config('api.base_uri'),
                'exceptions' => false,
                'decode_content' => true, // Explicit default
            ]);
        });
    }

    public function registerEmbedConverterService()
    {
        $this->app->singleton('embedconverterservice', function ($app) {
            return new EmbedConverterService();
        });
    }

    public function registerDamsImageService()
    {
        $this->app->singleton('damsimageservice', function ($app) {
            return new DamsImageService();
        });
    }

    public function registerClosureService()
    {
        $this->app->singleton('closureservice', function ($app) {
            return new class() {
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

    public function registerPrintService()
    {
        $this->app->singleton('printservice', function ($app) {
            return new class() {
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
     *
     * @return void
     */
    public function register()
    {
        config(['aic.version' => trim(file_get_contents(__DIR__ . '/../../VERSION'))]);
    }

    private function composeTemplatesViews()
    {
        $hour = Hour::today()->first();

        // WEB-2269: Consider moving some of this to a config?
        view()->composer('*', function ($view) use ($hour) {
            $view->with([
                'hour' => $hour,
                '_pages' => [
                    'visit' => route('visit')
                    , 'hours' => route('visit') . '#hours'
                    , 'directions' => route('visit') . '#directions'

                    , 'buy' => 'https://sales.artic.edu/admissions'
                    , 'become-a-member' => 'https://sales.artic.edu/memberships'
                    , 'shop' => 'https://shop.artic.edu/'

                    , 'collection' => route('collection')
                    , 'exhibitions' => route('exhibitions')
                    , 'events' => route('events')

                    , 'about-us' => '/about-us'
                    , 'about-us-identity-and-history' => '/about-us/identity-and-history'
                    , 'about-us-leadership' => '/about-us/leadership'
                    , 'about-us-departments' => '/about-us/departments'
                    , 'about-us-financial-reporting' => '/about-us/financial-reporting'

                    , 'support-us' => '/support-us'
                    , 'support-us-membership' => '/support-us/membership'
                    , 'support-us-luminary' => '/support-us/membership/luminary-levels'
                    , 'support-us-planned-giving' => '/support-us/ways-to-give/planned-giving'
                    , 'support-us-corporate-sponsorship' => '/support-us/ways-to-give/corporate-sponsorship'

                    , 'learn' => '/learn-with-us'
                    , 'learn-families' => '/learn-with-us/families'
                    , 'learn-teens' => '/learn-with-us/teens'
                    , 'learn-adults' => '/learn-with-us/adults'
                    , 'learn-educators' => '/learn-with-us/educators'

                    , 'follow-facebook' => 'https://www.facebook.com/artic'
                    , 'follow-twitter' => 'https://twitter.com/artinstitutechi'
                    , 'follow-instagram' => 'https://www.instagram.com/artinstitutechi/'
                    , 'follow-youtube' => 'https://www.youtube.com/user/ArtInstituteChicago'

                    , 'legal-articles' => route('articles')
                    , 'legal-employment' => '/employment'
                    , 'legal-venue-rental' => '/venue-rental'
                    , 'legal-contact' => '/contact'
                    , 'legal-press' => '/press'
                    , 'legal-terms' => '/terms'
                    , 'legal-image-licensing' => '/image-licensing'
                    , 'legal-saic' => 'https://www.saic.edu',
                ],
                'mobileNav' => [
                    [
                        'name' => 'Visit',
                        'slug' => route('visit'),
                    ],
                    [
                        'name' => 'Exhibition &amp; Events',
                        'children' => [
                            [
                                'name' => 'Exhibitions',
                                'slug' => route('exhibitions'),
                            ],
                            [
                                'name' => 'Events',
                                'slug' => route('events'),
                            ],
                        ],
                    ],
                    [
                        'name' => 'The Collection',
                        'slug' => route('collection'),
                        'children' => [
                            [
                                'name' => 'Artworks',
                                'slug' => route('collection'),
                            ],
                            [
                                'name' => 'Writings',
                                'slug' => route('articles_publications'),
                            ],
                            [
                                'name' => 'Resources',
                                'slug' => route('collection.research_resources'),
                            ],
                        ],
                    ],
                    [
                        'name' => 'Buy Tickets',
                        'slug' => 'https://sales.artic.edu/admissions',
                    ],
                    [
                        'name' => 'Become A Member',
                        'slug' => 'https://sales.artic.edu/memberships',
                    ],
                    [
                        'name' => 'Shop',
                        'slug' => 'https://shop.artic.edu/',
                    ],
                    [
                        'name' => 'About Us',
                        'slug' => route('genericPages.show', 'about-us'),
                    ],
                    [
                        'name' => 'Learn With Us',
                        'slug' => '/learn-with-us',
                    ],
                    [
                        'name' => 'Support Us',
                        'slug' => '/support-us',
                    ],
                ],

            ]);
        });
    }
}
