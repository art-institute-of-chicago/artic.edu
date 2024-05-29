<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Publication extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/publications',
        'resource' => '/api/v1/publications/{id}',
        'search' => '/api/v1/publications/search'
    ];

    public function articles()
    {
        return $this->hasMany(\App\Models\Api\Section::class, 'article_ids');
    }
}
