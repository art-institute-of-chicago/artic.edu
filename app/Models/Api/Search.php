<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use App\Libraries\Api\Builders\ApiModelBuilderSearch;
use Illuminate\Support\Carbon;

class Search extends BaseApiModel
{

    protected $endpoints = [
        'search' => '/api/v1/search'
    ];

    public $typeMap = [
        'artworks'    => 'App\Models\Api\Artwork',
        'exhibitions' => 'App\Models\Api\Exhibition'
    ];

    // Use a search Builder to overload the search function to allow
    // different types
    public function newApiModelBuilder($query)
    {
        return new ApiModelBuilderSearch($query);
    }

}
