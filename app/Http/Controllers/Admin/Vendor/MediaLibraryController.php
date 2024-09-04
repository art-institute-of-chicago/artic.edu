<?php

namespace App\Http\Controllers\Admin\Vendor;

use A17\Twill\Http\Controllers\Admin\MediaLibraryController as BaseMediaLibraryController;

class MediaLibraryController extends BaseMediaLibraryController
{
    /**
     * @param int|null $parentModuleId
     * @return array
     */
    public function index($parentModuleId = null)
    {
        if ($this->request->has('except')) {
            $prependScope['exceptIds'] = $this->request->get('except');
        }
        if ($this->request->has('withTag')) {
            $prependScope['withTag'] = $this->request->get('withTag');
        }
        if ($this->request->has('withoutTag')) {
            $prependScope['withoutTag'] = $this->request->get('withoutTag');
        }

        return $this->getIndexData($prependScope ?? []);
    }

    protected function getNamespace()
    {
        return 'App';
    }
}
