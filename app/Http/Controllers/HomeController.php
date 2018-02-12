<?php

namespace App\Http\Controllers;

// use A17\CmsToolkit\Http\Controllers\Front\Controller;

use A17\CmsToolkit\Models\Feature;

use App\Presenters\StaticObjectPresenter;

use Carbon\Carbon;


use App\Repositories\Api\ShopItemRepository;

use App\Models\Exhibition;
use App\Models\Page;
use App\Models\Api\ShopItem;

class HomeController extends Controller
{

    protected $shopItemRepository;

    public function index()
    {
        $page = Page::where('type', 0)->first();
        // $featuredExhibitions = $page->homeExhibitions;

        $products = $page->apiModels('homeShopItems', 'ShopItem');

        $featuredExhibitions = [new StaticObjectPresenter([
          "type" => "Exhibition",
          "id" => '1',
          "slug" => "/statics/exhibition",
          "title" => "Test Title",
          "dateStart" => Carbon::now(),
          "dateEnd" => Carbon::now(),
          "closingSoon" => true,
          "exclusive" => true,
          "nowOpen" => false,
          "image" => array(
            "src" => "//placeimg.com/700/300/nature",
            "srcset" => "//placeimg.com/700/300/nature 700w",
            "width" => 700,
            "height" => 300,
            "shareUrl" => '#',
            "shareTitle" => 'Share Title',
            "downloadUrl" => "#",
            "downloadName" => 'name',
            "credit" => 'credit',
            "creditUrl" => '#',
            )
        ])
        ];


        $view_data = [
            'heroExhibitions' => $featuredExhibitions
        ,   'intro' => $page->home_intro
        ,   'exhibitions' => []
        ,   'events' => []
        ,   'theCollection' => []
        ,   'products' => $products
        ];

        return view('home.index', $view_data);
    }
}
