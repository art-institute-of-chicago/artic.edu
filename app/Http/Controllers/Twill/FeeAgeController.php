<?php

namespace App\Http\Controllers\Twill;

class FeeAgeController extends BaseController
{
    public function setUpController(): void
    {
        $this->disablePublish();
        $this->disableBulkPublish();
        $this->enableReorder();
        $this->setModuleName('feeAges');
    }
}
