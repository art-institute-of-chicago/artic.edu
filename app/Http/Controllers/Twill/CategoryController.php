<?php

namespace App\Http\Controllers\Twill;

class CategoryController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->disablePublish();
        $this->enableEditInModal();
        $this->setModuleName('categories');
        $this->setTitleColumnKey('name');
        $this->setTitleColumnLabel('Name');
    }
}
