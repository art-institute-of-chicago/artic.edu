<?php

namespace App\Http\Controllers\API;

class PageFeaturesController extends BaseController
{
    protected $model = \App\Models\PageFeature::class;
    protected $transformer = \App\Http\Transformers\PageFeatureTransformer::class;
}
