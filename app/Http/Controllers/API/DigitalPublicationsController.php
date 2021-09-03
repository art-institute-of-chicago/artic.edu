<?php

namespace App\Http\Controllers\API;

class DigitalPublicationsController extends BaseController
{
    protected $model = \App\Models\DigitalPublication::class;
    protected $transformer = \App\Http\Transformers\DigitalPublicationTransformer::class;
}
