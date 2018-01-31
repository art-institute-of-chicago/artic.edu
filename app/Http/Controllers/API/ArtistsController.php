<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aic\Hub\Foundation\AbstractController as BaseController;

class ArtistsController extends BaseController
{
    protected $model = \App\Models\Artist::class;
    protected $transformer = \App\Http\Transformers\ArtistTransformer::class;
}
