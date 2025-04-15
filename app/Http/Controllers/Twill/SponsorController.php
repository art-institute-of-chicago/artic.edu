<?php

namespace App\Http\Controllers\Twill;

class SponsorController extends BaseController
{
    protected function setUpController(): void
    {
        $this->setModuleName('sponsors');
    }
}
