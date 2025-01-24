<?php

namespace App\Http\Controllers\Twill;

class SponsorController extends BaseController
{
    protected function setUpController(): void
    {
        parent::setUpController();
        $this->setModuleName('sponsors');
    }
}
