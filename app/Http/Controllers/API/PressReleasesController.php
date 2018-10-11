<?php

namespace App\Http\Controllers\API;

class PressReleasesController extends BaseController
{
    protected $model = \App\Models\PressRelease::class;
    protected $transformer = \App\Http\Transformers\PressReleaseTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
