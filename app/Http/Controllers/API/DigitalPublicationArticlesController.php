<?php

namespace App\Http\Controllers\API;

class DigitalPublicationArticlesController extends BaseController
{
    protected $model = \App\Models\DigitalPublicationArticle::class;
    protected $transformer = \App\Http\Transformers\ApiTransformer::class;
}
