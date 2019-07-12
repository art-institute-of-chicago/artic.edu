<?php

namespace App\Http\Controllers\API;

class EmailSeriesController extends BaseController
{
    protected $model = \App\Models\EmailSeries::class;
    protected $transformer = \App\Http\Transformers\ApiTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
