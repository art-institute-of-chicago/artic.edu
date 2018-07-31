<?php

namespace App\Http\Controllers;

use A17\Twill\Http\Controllers\Front\Controller as BaseController;
use View;

class FrontController extends BaseController
{
    public $seo;

    public function __construct()
    {
        parent::__construct();

        $this->loadSearchTerms();
        $this->loadBaseSeo();
    }

    protected function loadSearchTerms()
    {
        $terms = \App\Models\SearchTerm::ordered()->limit(10)->get();
        View::share('searchTerms', $terms);
    }

    protected function loadBaseSeo()
    {
        View::share('globalSuffix', 'The Art Institute of Chicago');
    }
}
