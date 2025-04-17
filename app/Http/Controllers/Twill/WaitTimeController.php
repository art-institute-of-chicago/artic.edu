<?php

namespace App\Http\Controllers\Twill;

class WaitTimeController extends \App\Http\Controllers\Twill\BaseApiController
{
    public function setUpController(): void
    {
        $this->setModuleName('waitTimes');
    }
}
