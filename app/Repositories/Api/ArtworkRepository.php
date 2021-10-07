<?php

namespace App\Repositories\Api;

use App\Models\Api\Artwork;

class ArtworkRepository extends BaseApiRepository
{
    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }
}
