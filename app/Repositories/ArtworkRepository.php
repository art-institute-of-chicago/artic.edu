<?php

namespace App\Repositories;

use App\Models\Artwork;
use App\Repositories\Api\BaseApiRepository;

class ArtworkRepository extends BaseApiRepository
{

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

}
