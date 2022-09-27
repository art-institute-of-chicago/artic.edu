<?php

namespace App\Http\Controllers\API;

class ArtworksController extends BaseController
{
    protected $model = \App\Models\Artwork::class;
    protected $transformer = \App\Http\Transformers\ArtworkTransformer::class;
}
