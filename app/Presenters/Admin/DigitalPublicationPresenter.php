<?php

namespace App\Presenters\Admin;

use App\Models\DigitalPublicationSection;
use App\Presenters\BasePresenter;

class DigitalPublicationPresenter extends BasePresenter
{
    /**
     * Formatted specifically for `_o-accordion`.
     */
    private $sectionsForSidebar = [];

    /**
     * This is an associative array, keyed by section type.
     * It will also have an `all` key, containing all sections.
     * This is done to reduce the number of DB queries.
     */
    private $sections = [];

    public function getCanonicalUrl()
    {
        return route('collection.publications.digital-publications.show', [
            'id' => $this->entity->id,
            'slug' => $this->entity->getSlug(),
        ]);
    }

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function hasSections($type = null)
    {
        return $this->getSections($type)->count() > 0;
    }

    public function getSections($type = null)
    {
        if (!isset($this->sections['all'])) {
            $this->sections['all'] = $this->entity
                ->sections()
                ->published()
                ->get();
        }

        if (!isset($type)) {
            return $this->sections['all'];
        }

        if (!isset($this->sections[$type])) {
            $this->sections[$type] = $this->sections['all']
                ->filter(function($section) use ($type) {
                    return $section->type === $type;
                })
                ->values();
        }

        return $this->sections[$type];
    }

    protected function isDscStub()
    {
        return $this->entity->is_dsc_stub ? 'Yes' : 'No';
    }

    public function sectionsForSidebar($currentSection = null)
    {
        if (!$this->sectionsForSidebar) {
            foreach (array_keys(DigitalPublicationSection::$types) as $type) {
                if (!$this->hasSections($type)) {
                    continue;
                }

                $this->sectionsForSidebar[] = [
                    'title' => DigitalPublicationSection::$types[$type],
                    'active' => false,
                    'blocks' => [
                        [
                            'type'  => 'link-list',
                            'links' => $this
                                ->getSections($type)
                                ->map(function($section) use ($currentSection) {
                                    return [
                                        'label' => $section->title,
                                        'href' => $section->present()->getSectionUrl($this->entity),
                                        'is_active' => isset($currentSection) && $section->id === $currentSection->id,
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
