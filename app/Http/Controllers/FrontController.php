<?php

namespace App\Http\Controllers;
use A17\CmsToolkit\Http\Controllers\Front\Controller as BaseController;
use View;

class FrontController extends BaseController
{
    public $seo;

    public function __construct()
    {
        parent::__construct();

        $this->loadSearchTerms();
    }

    protected function loadSearchTerms()
    {
        $terms = \App\Models\SearchTerm::ordered()->limit(10)->get()->pluck('name');
        View::share('searchTerms', $terms);
    }
}
