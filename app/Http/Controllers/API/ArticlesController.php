<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Behaviors\HideUnlisted;

class ArticlesController extends BaseController
{
    use HideUnlisted;

    protected $model = \App\Models\Article::class;
    protected $transformer = \App\Http\Transformers\ArticleTransformer::class;
}
