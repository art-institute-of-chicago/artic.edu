<?php

namespace App\Presenters\Admin;

use App\Models\DigitalPublicationSection;
use App\Presenters\BasePresenter;

class DigitalPublicationSectionPresenter extends BasePresenter
{
    private $sectionsForSidebar = [];

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

        if (!$this->sectionsForSidebar) {
            foreach (array_keys(DigitalPublicationSection::$types) as $type) {
                $this->sectionsForSidebar[] = [
                    'title' => DigitalPublicationSection::$types[$type],
                    'active' => false,
                    'blocks' => [
                        [
                            'type'  => 'link-list',
                            'links' => $this->entity
                                ->digitalPublication
                                ->present()
                                ->sectionsForLanding($type)
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
                        ],
                    ],
                ];
            }
        }

        return $this->sectionsForSidebar;
    }
}
