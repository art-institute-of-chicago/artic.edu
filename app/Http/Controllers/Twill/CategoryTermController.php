<?php

namespace App\Http\Controllers\Twill;

class CategoryTermController extends BaseApiController
{
    protected function setUpController(): void
    {
        $this->enableAugmentedModel();
        $this->disablePublish();
        $this->setModuleName('categoryTerms');
    }
}
