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

        $addToSidebar = function($section) use ($currentSection) {
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
        };

        return $this->sectionsForSidebar ?? $this->sectionsForSidebar = [
            [
                'title' => 'About',
                'active' => false,
                'blocks' => [
                    [
                        'type'  => 'link-list',
                        'links' => $this->entity
                            ->digitalPublication
                            ->present()
                            ->aboutsForLanding()
                            ->map($addToSidebar),
                    ]
                ],
            ],
            [
                'title' => 'Texts',
                'active' => false,
                'blocks' => [
                    [
                        'type'  => 'link-list',
                        'links' => $this->entity
                            ->digitalPublication
                            ->present()
                            ->textsForLanding()
                            ->map($addToSidebar),
                    ]
                ],
            ],
            [
                'title' => 'Galleries',
                'active' => false,
                'blocks' => [
                    [
                        'type'  => 'link-list',
                        'links' => $this->entity
                            ->digitalPublication
                            ->present()
                            ->galleriesForLanding()
                            ->map($addToSidebar),
                    ]
                ],
            ],
        ];
    }
}
