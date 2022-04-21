<?php

namespace App\Http\Controllers\API;

class BuildingClosuresController extends BaseController
{
    protected $model = \App\Models\BuildingClosure::class;
    protected $transformer = \App\Http\Transformers\BuildingClosureTransformer::class;
}
