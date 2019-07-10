<?php

namespace App\Http\Controllers\API;

class VideosController extends BaseController
{
    protected $model = \App\Models\Video::class;
    protected $transformer = \App\Http\Transformers\VideoTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
