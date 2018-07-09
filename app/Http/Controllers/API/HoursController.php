<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HoursController extends BaseController
{
    protected $model = \App\Models\Hour::class;
    protected $transformer = \App\Http\Transformers\HourTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
