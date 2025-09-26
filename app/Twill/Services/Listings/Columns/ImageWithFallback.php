<?php

namespace App\Twill\Services\Listings\Columns;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Image;
use Closure;

class ImageWithFallback extends Image
{
    private ?Closure $fallbackFn = null;

    public function fallback(Closure $fallbackFn): static
    {
        $this->fallbackFn = $fallbackFn;
        return $this;
    }

    public function getThumbnail(TwillModelContract $model): ?string
    {
        $role = $this->role ?? head(array_keys($model->getMediasParams()));
        $crop = $this->crop ?? head(array_keys($model->getMediasParams()[$role]));
        $params = $this->mediaParams ?? ['w' => 80, 'h' => 80, 'fit' => 'crop'];
        $fallback = $this->fallbackFn;

        return $model->image($role, $crop, $params, has_fallback: true, cms: true)
            ??  ($fallback ? $fallback($model) : '');
    }
}
