<?php

namespace App\Http\Controllers\API;

class GenericPagesController extends BaseController
{
    protected $model = \App\Models\GenericPage::class;
    protected $transformer = \App\Http\Transformers\GenericPageTransformer::class;

    /**
     * Exclude any pages with `redirect_url` set.
     */
    protected function getBaseQuery()
    {
        return parent::getBaseQuery()->whereNull('redirect_url');
    }
}
