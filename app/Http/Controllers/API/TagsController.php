<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aic\Hub\Foundation\AbstractController as BaseController;

class TagsController extends BaseController
{
    protected $model = \App\Models\SiteTag::class;
    protected $transformer = \App\Http\Transformers\SiteTagTransformer::class;
}
