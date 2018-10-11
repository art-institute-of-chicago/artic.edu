<?php

namespace App\Http\Controllers\API;

class GenericPagesController extends BaseController
{
    protected $model = \App\Models\GenericPage::class;
    protected $transformer = \App\Http\Transformers\GenericPageTransformer::class;

    public function validateId($id)
    {
        return true;
    }

}
