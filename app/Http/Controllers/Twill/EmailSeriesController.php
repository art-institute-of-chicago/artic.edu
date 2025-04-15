<?php

namespace App\Http\Controllers\Twill;

class EmailSeriesController extends BaseController
{
    protected function setUpController(): void
    {
        $this->enableReorder();
        $this->setModuleName('emailSeries');
    }
}
