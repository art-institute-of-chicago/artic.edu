<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PressReleasesController extends BaseController
{
    protected $model = \App\Models\PressRelease::class;
    protected $transformer = \App\Http\Transformers\PressReleaseTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
