<?php

namespace App\Http\Controllers;

use App\Models\Page;

class HomeController extends FrontController
{

    public function index()
    {
        $this->seo->setTitle("Downtown Chicago's #1 Museum");
        $this->seo->setDescription("Located downtown by Millennium Park, this top art museum is TripAdvisor's #1 Chicago attraction—a must when visiting the city.");

        $page = Page::forType('Home')->first();

        $exhibitions = $page->apiModels('homeExhibitions', 'Exhibition');
        $products    = $page->apiModels('homeShopItems', 'ShopItem');
        $events      = $page->homeEvents;

        $mainFeatures       = $page->homeFeatures()->published()->limit(3)->get();
        $collectionFeatures = $page->collectionFeatures()->published()->get();

        $view_data = [
            'contrastHeader' => sizeof($mainFeatures) > 0,
            'filledLogo'     => sizeof($mainFeatures) > 0,
            'mainFeatures' => $mainFeatures,
            'intro' => $page->home_intro,
            'exhibitions' => $exhibitions,
            'events' => $events,
            'theCollection' => $collectionFeatures,
            'products' => $products,
            'membership_module_image' => $page->imageFront('home_membership_module_image'),
            'membership_module_url' => $page->home_membership_module_url,
            'membership_module_headline' =>  $page->home_membership_module_headline,
            'membership_module_button_text' => $page->home_membership_module_button_text,
            'membership_module_short_copy' => $page->home_membership_module_short_copy,
        ];

        return view('site.home', $view_data);
    }

}
