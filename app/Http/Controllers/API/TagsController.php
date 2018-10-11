<?php

namespace App\Http\Controllers\API;

class TagsController extends BaseController
{
    protected $model = \App\Models\SiteTag::class;
    protected $transformer = \App\Http\Transformers\SiteTagTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
