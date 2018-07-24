<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class CategoryTerm extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/category-terms',
        'resource' => '/api/v1/category-terms/{id}',
        'search' => '/api/v1/category-terms/search',
    ];

    protected $presenter = 'App\Presenters\Admin\CategoryTermPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\CategoryTermPresenter';

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\CategoryTerm';

    public $subtypeToParameter = [
        'style' => 'style_ids',
        'material' => 'material_ids',
        'subject' => 'subject_ids',
        'department' => 'department_ids',
        'classification' => 'classification_ids',

        // Hidden ones from the filters.
        'technique' => 'technique_ids',
        'theme' => 'theme_ids',
    ];

    public function getParameterName()
    {
        return collect($this->subtypeToParameter)->get($this->subtype);
    }

}
