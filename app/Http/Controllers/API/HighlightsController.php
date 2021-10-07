<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Behaviors\HideUnlisted;

class HighlightsController extends BaseController
{
    use HideUnlisted;

    protected $model = \App\Models\Highlight::class;
    protected $transformer = \App\Http\Transformers\HighlightTransformer::class;
}
