<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

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
