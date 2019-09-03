<?php

namespace App\Http\Controllers\API;

class ExperiencesController extends BaseController
{
    protected $model = \App\Models\Experience::class;
    protected $transformer = \App\Http\Transformers\ExperienceTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
