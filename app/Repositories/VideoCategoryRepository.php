<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\VideoCategory;

class VideoCategoryRepository extends ModuleRepository
{
    public function __construct(VideoCategory $model)
    {
        $this->model = $model;
    }
}
