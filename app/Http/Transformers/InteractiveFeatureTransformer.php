<?php

namespace App\Http\Transformers;

class InteractiveFeatureTransformer extends ApiTransformer
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['experiences'];

}
