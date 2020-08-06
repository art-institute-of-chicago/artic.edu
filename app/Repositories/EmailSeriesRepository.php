<?php

namespace App\Repositories;

use App\Models\EmailSeries;

class EmailSeriesRepository extends ModuleRepository
{
    public function __construct(EmailSeries $model)
    {
        $this->model = $model;
    }
}
