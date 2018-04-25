<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aic\Hub\Foundation\AbstractController as BaseController;

class ResearchGuidesController extends BaseController
{
    protected $model = \App\Models\ResearchGuide::class;
    protected $transformer = \App\Http\Transformers\ResearchGuideTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
