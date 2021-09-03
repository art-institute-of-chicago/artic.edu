<?php

namespace App\Http\Controllers\API;

class HoursController extends BaseController
{
    protected $model = \App\Models\Hour::class;
    protected $transformer = \App\Http\Transformers\HourTransformer::class;
}
