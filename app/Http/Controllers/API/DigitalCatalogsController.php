<?php

namespace App\Http\Controllers\API;

class DigitalCatalogsController extends BaseController
{
    protected $model = \App\Models\DigitalCatalog::class;
    protected $transformer = \App\Http\Transformers\DigitalCatalogTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
