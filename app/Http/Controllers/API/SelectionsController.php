<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Behaviors\HideUnlisted;

class SelectionsController extends BaseController
{
    use HideUnlisted;

    protected $model = \App\Models\Selection::class;
    protected $transformer = \App\Http\Transformers\SelectionTransformer::class;
}
