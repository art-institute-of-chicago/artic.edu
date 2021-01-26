<?php

namespace App\Jobs;

use Artisan;

class GeneratePdf extends BaseJob
{
    protected $event;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function handle()
    {
        if (config('app.env') == 'production' || config('app.env') == 'staging')
        {
            Artisan::call('pdfs:generate-one', ['model' => get_class($this->model), 'id' => $this->model->id]);
        }
    }
}
