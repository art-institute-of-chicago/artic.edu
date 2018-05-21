<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\Question;

class QuestionRepository extends ModuleRepository
{
    public function __construct(Question $model)
    {
        $this->model = $model;
    }
}
