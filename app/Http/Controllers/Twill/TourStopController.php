<?php

namespace App\Http\Controllers\Twill;

class TourStopController extends \App\Http\Controllers\Twill\BaseApiController
{
    public function setUpController(): void
    {
        $this->setModuleName('tourStops');
    }
}
