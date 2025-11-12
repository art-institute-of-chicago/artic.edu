<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class VideoCategoryController extends BaseModuleController
{
    protected function setUpController(): void
    {
        $this->disableBulkPublish();
        $this->disablePermalink();
        $this->disablePublish();

        $this->setTitleColumnKey('name');
        $this->setTitleColumnLabel('Name');
        $this->setModuleName('videoCategories');
    }
}
