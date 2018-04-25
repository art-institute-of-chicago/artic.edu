<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aic\Hub\Foundation\AbstractController as BaseController;

class DigitalCatalogsController extends BaseController
{
    protected $model = \App\Models\DigitalCatalog::class;
    protected $transformer = \App\Http\Transformers\DigitalCatalogTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
