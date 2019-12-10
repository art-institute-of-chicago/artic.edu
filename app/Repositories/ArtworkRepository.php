<?php

namespace App\Repositories;

use App\Repositories\Behaviors\HandleFeaturedRelated;
use App\Models\Artwork;
use App\Repositories\Api\BaseApiRepository;

class ArtworkRepository extends BaseApiRepository
{
    use HandleFeaturedRelated;

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

}
