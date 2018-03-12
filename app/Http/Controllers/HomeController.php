<?php

namespace App\Http\Controllers;

use A17\CmsToolkit\Models\Feature;

use App\Presenters\StaticObjectPresenter;
use App\Repositories\Api\ShopItemRepository;
use App\Repositories\Api\ExhibitionRepository;
use App\Repositories\Api\EventRepository;

use App\Models\Event;
use App\Models\Exhibition;
use App\Models\Page;
use App\Models\Api\ShopItem;

use Carbon\Carbon;

class HomeController extends FrontController
{

    protected $shopItemRepository;
    protected $exhibitionRepository;

    public function __construct(ExhibitionRepository $exhibitionRepository) {
        $this->exhibitionRepository = $exhibitionRepository;
    }

    public function index()
    {
        $page = Page::where('type', 0)->first();


        $exhibitions = $page->apiModels('homeExhibitions', 'Exhibition');
        $events = $page->homeEvents;

        $products = $page->apiModels('homeShopItems', 'ShopItem');

        $mainFeatures = collect([]);
        $mainFeatureBucket = Feature::forBucket('home_main_features');
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

        // sort by published?
        $mainFeatures = $mainFeatures->slice(0, 3);
        $membership_module_url = $page->home_membership_module_url;

        $view_data = [
            'mainFeatures' => $mainFeatures
        ,   'intro' => $page->home_intro
        ,   'exhibitions' => $exhibitions
        ,   'events' => $events
        ,   'theCollection' => []
        ,   'products' => $products
        ,   'membership_module_image' => $page->imageFront('home_membership_module_image')
        ,   'membership_module_url' => $membership_module_url
        ];

        return view('home.index', $view_data);
    }
}
