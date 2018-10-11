<?php

namespace App\Http\Controllers\API;

class PagesController extends BaseController
{
    protected $model = \App\Models\Page::class;
    protected $transformer = \App\Http\Transformers\PageTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
