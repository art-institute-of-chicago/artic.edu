<?php

namespace App\Http\Controllers\API;

class ResearchGuidesController extends BaseController
{
    protected $model = \App\Models\ResearchGuide::class;
    protected $transformer = \App\Http\Transformers\ResearchGuideTransformer::class;
}
