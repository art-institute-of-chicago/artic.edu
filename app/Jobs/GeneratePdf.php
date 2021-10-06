<?php

namespace App\Jobs;

use Artisan;

class GeneratePdf extends BaseJob
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function handle()
    {
        if (!config('aic.pdf_on_save')) {
            return;
        }

        Artisan::call('pdfs:generate-one', [
            'model' => get_class($this->model),
            'id' => $this->model->id,
        ]);
    }
}
