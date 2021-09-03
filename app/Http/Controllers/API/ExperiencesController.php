<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Behaviors\HideUnlisted;

class ExperiencesController extends BaseController
{
    use HideUnlisted;

    protected $model = \App\Models\Experience::class;
    protected $transformer = \App\Http\Transformers\ExperienceTransformer::class;
}
