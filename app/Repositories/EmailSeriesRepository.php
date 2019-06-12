<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\EmailSeries;

class EmailSeriesRepository extends ModuleRepository
{
    

    public function __construct(EmailSeries $model)
    {
        $this->model = $model;
    }
}
