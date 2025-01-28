<?php

namespace App\Http\Controllers\Twill;

class CatalogCategoryController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->disablePublish();
        $this->enableEditInModal();
        $this->setModuleName('catalogCategories');
        $this->setTitleColumnKey('name');
        $this->setTitleColumnLabel('Name');
    }
}
