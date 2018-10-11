<?php

namespace App\Http\Controllers\API;

use Aic\Hub\Foundation\AbstractController as BaseController;

class ArtistsController extends BaseController
{
    protected $model = \App\Models\Artist::class;
    protected $transformer = \App\Http\Transformers\ArtistTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
