<?php

namespace App\Http\Controllers\Admin\Vendor;

use A17\Twill\Http\Controllers\Admin\MediaLibraryController as BaseMediaLibraryController;
use A17\Twill\Services\Uploader\SignS3Upload;
use A17\Twill\Services\Uploader\SignAzureUpload;
use Illuminate\Http\Request;

class PublicationMediaLibraryController extends BaseMediaLibraryController
{

    protected $moduleName = 'publicationMedias';

    public function signS3Upload(Request $request, SignS3Upload $signS3Upload)
    {
        return $signS3Upload->fromPolicy($request->getContent(), $this, $this->config->get('twill.publication_media_library.disk'));
    }

    public function signAzureUpload(Request $request, SignAzureUpload $signAzureUpload)
    {
        return $signAzureUpload->getSasUrl($request, $this, $this->config->get('twill.publication_media_library.disk'));
    }

    protected function getNamespace()
    {
        return 'App';
    }
}
