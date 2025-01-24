<?php

namespace App\Http\Controllers\Twill;

class EmailSeriesController extends BaseController
{
    protected function setUpController(): void
    {
        parent::setUpController();
        $this->enableReorder();
        $this->setModuleName('emailSeries');
    }
}
