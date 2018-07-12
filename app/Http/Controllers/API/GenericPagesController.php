<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenericPagesController extends BaseController
{
    protected $model = \App\Models\GenericPage::class;
    protected $transformer = \App\Http\Transformers\GenericPageTransformer::class;

    public function validateId($id)
    {
        return true;
    }

}
