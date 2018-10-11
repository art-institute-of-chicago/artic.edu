<?php

namespace App\Http\Controllers\API;

class EventsController extends BaseController
{
    protected $model = \App\Models\Event::class;
    protected $transformer = \App\Http\Transformers\ApiTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
