<?php

namespace App\Presenters\Admin;

use App\Models\DigitalPublicationSection;
use App\Presenters\BasePresenter;

class DigitalPublicationSectionPresenter extends BasePresenter
{
    public function getCanonicalUrl()
    {
        return $this->getSectionUrl($this->entity->digitalPublication);
    }

    public function type()
    {
        if ($this->entity->type) {
            return DigitalPublicationSection::$types[$this->entity->type];
        }
    }

    public function pdfDownloadPath()
    {
        return config('aic.pdf_s3_endpoint') . $this->entity->pdf_download_path;
    }

    public function getSectionUrl($digitalPublication, $section = null)
    {
        $section = $section ?? $this->entity;

        return route('collection.publications.digital-publications-sections.show', [
            'pubId' => $digitalPublication->id,
            'pubSlug' => $digitalPublication->slug,
            'id' => $section->id,
            'slug' => $section->slug,
        ]);
    }

    public function getSectionType()
    {
        if (isset($this->entity->type_display)) {
            return $this->entity->type_display;
        }

        switch ($this->entity->type) {
            case DigitalPublicationSection::TEXT:
                return 'Essay';
                break;
            case DigitalPublicationSection::WORK:
                return 'Gallery';
                break;
        }

        return $this->entity->type;
    }
}
