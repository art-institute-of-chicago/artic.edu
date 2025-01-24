<?php

namespace App\Http\Controllers\Twill;

class HomeFeatureController extends BaseController
{
    public function setUpController(): void
    {
        parent::setUpController();
        $this->setModuleName('homeFeatures');
    }
}
