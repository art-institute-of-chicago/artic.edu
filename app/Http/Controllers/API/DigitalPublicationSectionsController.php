<?php

namespace App\Http\Controllers\API;

class DigitalPublicationSectionsController extends BaseController
{
    protected $model = \App\Models\DigitalPublicationSection::class;
    protected $transformer = \App\Http\Transformers\ApiTransformer::class;
}
