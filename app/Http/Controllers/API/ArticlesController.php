<?php

namespace App\Http\Controllers\API;

class ArticlesController extends BaseController
{
    protected $model = \App\Models\Article::class;
    protected $transformer = \App\Http\Transformers\ArticleTransformer::class;

    /**
     * Exclude unlisted articles.
     *
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate($limit)
    {
        return ($this->model)::notUnlisted()->orderBy('updated_at', 'desc')->paginate($limit);
    }
}
