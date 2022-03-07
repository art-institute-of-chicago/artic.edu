<?php

namespace App\Http\Controllers\API;

class IssuesController extends BaseController
{
    protected $model = \App\Models\Issue::class;
    protected $transformer = \App\Http\Transformers\IssueTransformer::class;
}
