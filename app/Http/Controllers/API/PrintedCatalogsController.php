<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aic\Hub\Foundation\AbstractController as BaseController;

class PrintedCatalogsController extends BaseController
{
    protected $model = \App\Models\PrintedCatalog::class;
    protected $transformer = \App\Http\Transformers\PrintedCatalogTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
