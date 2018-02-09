<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aic\Hub\Foundation\AbstractController as BaseController;

class PagesController extends BaseController
{
    protected $model = \App\Models\Page::class;
    protected $transformer = \App\Http\Transformers\PageTransformer::class;
}
