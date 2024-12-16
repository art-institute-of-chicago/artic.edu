<?php

namespace App\Http\Controllers\Twill\Columns;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Image;
use App\Models\Behaviors\HasMediasApi;
use InvalidArgumentException;

class ApiImage extends Image
{
    protected function getRenderValue(TwillModelContract $model): string
    {
        if (method_exists($model, 'getApiModel')) {
            $model = $model->getApiModel();
        }
        if (!classHasTrait($model::class, HasMediasApi::class)) {
            throw new InvalidArgumentException('Cannot use image column on model not implementing HasMediasApi trait');
        }
        if ($renderFunction = $this->render) {
            return $renderFunction($model);
        }

        return $this->getThumbnail($model);
    }
}
