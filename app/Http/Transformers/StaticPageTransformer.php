<?php

namespace App\Http\Transformers;

class StaticPageTransformer extends ApiTransformer
{

    public function transform($item) {
        return $item->toArray();
    }

}
