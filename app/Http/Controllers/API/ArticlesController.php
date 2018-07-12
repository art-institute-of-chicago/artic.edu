<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticlesController extends BaseController
{
    protected $model = \App\Models\Article::class;
    protected $transformer = \App\Http\Transformers\ArticleTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
