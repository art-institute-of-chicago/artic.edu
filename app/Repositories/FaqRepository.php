<?php

namespace App\Repositories;


use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Faq;

class FaqRepository extends ModuleRepository
{
    

    public function __construct(Faq $model)
    {
        $this->model = $model;
    }
}
