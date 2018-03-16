<?php

namespace App\Http\Controllers;

use A17\CmsToolkit\Models\Feature;

use App\Presenters\StaticObjectPresenter;
use App\Repositories\Api\ShopItemRepository;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\Api\EventRepository;
use App\Repositories\Api\ArtworkRepository;

use App\Models\Event;
use App\Models\Exhibition;
use App\Models\Page;
use App\Models\Api\ShopItem;

use Carbon\Carbon;

class HomeController extends FrontController
{

    protected $shopItemRepository;
    protected $exhibitionRepository;

    public function __construct(ExhibitionRepository $exhibitionRepository, ArtworkRepository $artworkRepository) {
        $this->exhibitionRepository = $exhibitionRepository;
        $this->artworkRepository = $artworkRepository;

        parent::__construct();
    }

    public function index()
    {
        $page = Page::where('type', 0)->first();

        $exhibitions = $page->apiModels('homeExhibitions', 'Exhibition');
        $events = $page->homeEvents;

        $products = $page->apiModels('homeShopItems', 'ShopItem');

        $mainFeatures = collect([]);
        $mainFeatureBucket = $page->homeFeatures;
        foreach($mainFeatureBucket as $feature) {
            $item = null;
            if ($feature->published) {
                if ($feature->events->count()) {
                    $item = $feature->events()->first();
                    $item->type= 'exhibition';
                    $item->dateStart = Carbon::now();
                    $item->dateEnd = Carbon::now();
                } else if ($feature->exhibitions->count()) {
                    $item = $this->exhibitionRepository->getById($feature->exhibitions()->first()->datahub_id);

                    $item->type= 'exhibition';
                } else if ($feature->articles->count()) {
                    $item = $feature->articles()->first();
                    $item->type= 'article';
                    $item->dateStart = Carbon::now();
                    $item->dateEnd = Carbon::now();
                }

                if ($item) {
                    $mainFeatures[] = $item;
                }
            }
        }
        // TODO: sort by published or leave in position order?
        $mainFeatures = $mainFeatures->slice(0, 3);

        $collectionFeatures = collect([]);
        $collectionFeatureBucket = $page->collectionFeatures;
        foreach($collectionFeatureBucket as $feature) {
            $item = null;
            if ($feature->published) {
                if ($feature->articles->count()) {
                    $item = $feature->articles()->first();
                    $item->type= 'article';

                } else if ($feature->artworks->count()) {
                    $item = $this->artworkRepository->getById($feature->artworks()->first()->datahub_id);
                    $item->type= 'artwork';

                } else if ($feature->selections->count()) {
                    $item = $feature->selections()->first();

                    $item->type= 'selection';
                    $item->images = $item->getArtworkImages();
                }

                if ($item) {
                    $collectionFeatures[] = $item;
                }
            }
        }


        $membership_module_url = $page->home_membership_module_url;
        $membership_module_headline = $page->home_membership_module_headline;
        $membership_module_button_text = $page->home_membership_module_button_text;
        $membership_module_short_copy = $page->home_membership_module_short_copy;

        $view_data = [
            'mainFeatures' => $mainFeatures
        ,   'intro' => $page->home_intro
        ,   'exhibitions' => $exhibitions
        ,   'events' => $events
        ,   'theCollection' => $collectionFeatures
        ,   'products' => $products
        ,   'membership_module_image' => $page->imageFront('home_membership_module_image')
        ,   'membership_module_url' => $membership_module_url
        ,   'membership_module_headline' => $membership_module_headline
        ,   'membership_module_button_text' => $membership_module_button_text
        ,   'membership_module_short_copy' => $membership_module_short_copy
        ];

        return view('home.index', $view_data);
    }
}
