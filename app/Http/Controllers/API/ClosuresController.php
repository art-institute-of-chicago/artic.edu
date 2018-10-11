<?php

namespace App\Http\Controllers\API;

class ClosuresController extends BaseController
{
    protected $model = \App\Models\Closure::class;
    protected $transformer = \App\Http\Transformers\ClosureTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
