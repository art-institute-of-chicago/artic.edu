<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aic\Hub\Foundation\AbstractController as BaseController;

class SelectionsController extends BaseController
{
    protected $model = \App\Models\Selection::class;
    protected $transformer = \App\Http\Transformers\SelectionTransformer::class;
}
