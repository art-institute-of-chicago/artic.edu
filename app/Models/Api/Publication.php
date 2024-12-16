<?php

namespace App\Models\Api;

use Aic\Hub\Foundation\Library\Api\Models\BaseApiModel;

class Publication extends BaseApiModel
{
    protected array $endpoints = [
        'collection' => '/api/v1/publications',
        'resource' => '/api/v1/publications/{id}',
        'search' => '/api/v1/publications/search'
    ];

    public function articles()
    {
        return $this->hasMany(\App\Models\Api\Section::class, 'article_ids');
    }
}
