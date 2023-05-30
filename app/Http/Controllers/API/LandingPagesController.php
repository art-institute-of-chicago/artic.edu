<?php

namespace App\Http\Controllers\API;

class LandingPagesController extends BaseController
{
    protected $model = \App\Models\LandingPage::class;
    protected $transformer = \App\Http\Transformers\LandingPageTransformer::class;
}
