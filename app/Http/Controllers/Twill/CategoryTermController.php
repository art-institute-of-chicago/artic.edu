<?php

namespace App\Http\Controllers\Twill;

class CategoryTermController extends BaseApiController
{
    protected function setUpController(): void
    {
        parent::setUpController();
        $this->enableAugmentedModel();
        $this->setModuleName('categoryTerms');
    }
}
