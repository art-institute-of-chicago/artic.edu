<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository extends ModuleRepository
{
    public function __construct(Question $model)
    {
        $this->model = $model;
    }
}
