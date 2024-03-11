<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class MyMuseumTourPresenter extends BasePresenter
{
    public function pdfDownloadPath()
    {
        if (!isset($this->entity->pdf_download_path)) {
            return;
        }

        return config('aic.pdf_s3_endpoint') . $this->entity->pdf_download_path;
    }
}
