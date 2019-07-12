<?php

namespace App\Http\Controllers\API;

class SponsorsController extends BaseController
{
    protected $model = \App\Models\Sponsor::class;
    protected $transformer = \App\Http\Transformers\ApiTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
