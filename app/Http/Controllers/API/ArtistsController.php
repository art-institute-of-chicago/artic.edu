<?php

namespace App\Http\Controllers\API;

class ArtistsController extends BaseController
{
    protected $model = \App\Models\Artist::class;
    protected $transformer = \App\Http\Transformers\ArtistTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
