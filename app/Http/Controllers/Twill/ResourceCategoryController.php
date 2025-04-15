<?php

namespace App\Http\Controllers\Twill;

class ResourceCategoryController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->disablePublish();
        $this->enableEditInModal();
        $this->enableReorder();
        $this->setModuleName('resourceCategories');
        $this->setTitleColumnKey('name');
        $this->setTitleColumnLabel('Name');
    }
}
