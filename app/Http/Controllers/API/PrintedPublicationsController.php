<?php

namespace App\Http\Controllers\API;

class PrintedPublicationsController extends BaseController
{
    protected $model = \App\Models\PrintedPublication::class;
    protected $transformer = \App\Http\Transformers\PrintedPublicationTransformer::class;
}
