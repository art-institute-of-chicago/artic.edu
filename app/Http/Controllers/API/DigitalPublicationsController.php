<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Behaviors\HideUnlisted;

class DigitalPublicationsController extends BaseController
{
    use HideUnlisted;

    protected $model = \App\Models\DigitalPublication::class;
    protected $transformer = \App\Http\Transformers\DigitalPublicationTransformer::class;
}
