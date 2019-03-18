<?php

namespace App\Http\Controllers\API;

class DigitalLabelsController extends BaseController
{
    protected $model = \App\Models\DigitalLabel::class;
    protected $transformer = \App\Http\Transformers\DigitalLabelTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
