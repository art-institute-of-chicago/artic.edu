<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class DigitalPublicationSectionPresenter extends BasePresenter
{
    public function type()
    {
        if ($this->entity->type) {
            return \App\Models\DigitalPublicationSection::$types[$this->entity->type];
        }
    }

    public function pdfDownloadPath()
    {
        return config('aic.pdf_s3_endpoint') . $this->entity->pdf_download_path;
    }

    public function sectionsForSidebar()
    {
        $currentSection = $this->entity;

        return $this->sectionsForSidebar ?? $this->sectionsForSidebar = [
            [
                'title' => 'View other sections',
                'active' => false,
                'blocks' => [
                    [
                        'type'  => 'link-list',
                        'links' => $this->entity
                            ->digitalPublication
                            ->present()
                            ->sectionsForLanding()
                            ->map(function($section) use ($currentSection) {
                                return [
                                    'label' => $section->title,
                                    'href' => route('collection.publications.digital-publications-sections.show', [
                                        'pubId' => $section->digitalPublication->id,
                                        'pubSlug' => $section->digitalPublication->getSlug(),
                                        'type' => $section->type,
                                        'id' => $section->id,
                                        'slug' => $section->getSlug(),
                                    ]),
                                    'is_active' => $section->id === $currentSection->id,
                                ];
                            }),
                    ]
                ],
            ],
        ];
    }
}
