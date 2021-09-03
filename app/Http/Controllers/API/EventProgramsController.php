<?php

namespace App\Http\Controllers\API;

class EventProgramsController extends BaseController
{
    protected $model = \App\Models\EventProgram::class;
    protected $transformer = \App\Http\Transformers\ApiTransformer::class;
}
