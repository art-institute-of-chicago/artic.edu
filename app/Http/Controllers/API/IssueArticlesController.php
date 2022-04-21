<?php

namespace App\Http\Controllers\API;

class IssueArticlesController extends BaseController
{
    protected $model = \App\Models\IssueArticle::class;
    protected $transformer = \App\Http\Transformers\IssueArticleTransformer::class;
}
