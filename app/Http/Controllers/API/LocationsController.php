<?php

namespace App\Http\Controllers\API;

class LocationsController extends BaseController
{
    protected $model = \App\Models\Location::class;
    protected $transformer = \App\Http\Transformers\LocationTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
