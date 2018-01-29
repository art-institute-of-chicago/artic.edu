<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use A17\CmsToolkit\Models\Behaviors\HasPresenter;
use Illuminate\Support\Carbon;

class Exhibition extends BaseApiModel
{
    use HasPresenter;

    protected $endpoints = [
        'collection' => '/api/v1/exhibitions',
        'resource'   => '/api/v1/exhibitions/{id}',
        'search'     => '/api/v1/exhibitions/search'
    ];

    // protected $casts = [
    //     'start_at' => 'datetime'
    // ];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Exhibition';

    protected $presenterAdmin      = 'App\Presenters\Admin\ExhibitionPresenter';

    // Solve this using casts. Because it returns an object it can't be used on the CMS
    // Add a value option
    public function getStartAtAttribute($value) {
        return $this->asDateTime($value)->format("Y-m-d h:m:s T");
    }

    public function getEndAtAttribute($value) {
        return $this->asDateTime($value)->format("Y-m-d h:m:s T");
    }
}
