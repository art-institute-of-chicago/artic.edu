<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aic\Hub\Foundation\AbstractController as BaseController;

class EventsController extends BaseController
{
    protected $model = \App\Models\Event::class;
    protected $transformer = \App\Http\Transformers\EventTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
