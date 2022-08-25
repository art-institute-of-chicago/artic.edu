<?php

namespace App\Repositories\Api;

use App\Models\Api\Publication;

class PublicationRepository extends BaseApiRepository
{
    public function __construct(Publication $model)
    {
        $this->model = $model;
    }
}
