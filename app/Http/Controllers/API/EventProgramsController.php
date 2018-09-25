<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventProgramsController extends BaseController
{
    protected $model = \App\Models\EventProgram::class;
    protected $transformer = \App\Http\Transformers\ApiTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
