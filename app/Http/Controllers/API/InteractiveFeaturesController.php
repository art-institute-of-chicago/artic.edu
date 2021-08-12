<?php

namespace App\Http\Controllers\API;

class InteractiveFeaturesController extends BaseController
{
    protected $model = \App\Models\InteractiveFeature::class;
    protected $transformer = \App\Http\Transformers\InteractiveFeatureTransformer::class;
}
