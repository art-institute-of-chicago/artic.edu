<?php

namespace App\Http\Controllers\API;

class PrintedCatalogsController extends BaseController
{
    protected $model = \App\Models\PrintedCatalog::class;
    protected $transformer = \App\Http\Transformers\PrintedCatalogTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
