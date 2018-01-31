<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aic\Hub\Foundation\AbstractController as BaseController;

class LocationsController extends BaseController
{
    protected $model = \App\Models\Location::class;
    protected $transformer = \App\Http\Transformers\LocationTransformer::class;
}
