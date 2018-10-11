<?php

namespace App\Http\Controllers\API;

use Aic\Hub\Foundation\AbstractController as BaseController;

class PagesController extends BaseController
{
    protected $model = \App\Models\Page::class;
    protected $transformer = \App\Http\Transformers\PageTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
