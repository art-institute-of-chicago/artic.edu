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
        if (!isset($this->entity->pdf_download_path)) {
            return;
        }

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

    /**
     * PUB-163: Use for cards, not for sidebar.
     */
    public function getSectionType()
    {
        return $this->entity->type_display;
    }

    public function references()
    {
        if (empty($this->entity->references)) {
            return;
        }

        return $this->addCssClass($this->entity->references, 'f-secondary');
    }

    public function citeAs()
    {
        if (empty($this->entity->cite_as)) {
            return;
        }

        return $this->addCssClass($this->entity->cite_as, 'f-secondary');
    }
}
