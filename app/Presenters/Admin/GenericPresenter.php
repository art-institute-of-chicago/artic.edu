<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class GenericPresenter extends BasePresenter
{

    public function date() {
        if (!empty($this->entity->publish_start_date)) {
            return $this->entity->publish_start_date->format('F j, Y');
        }
    }

    public function breadCrumb()
    {
        $crumbs = [];

        $ancestors = $this->entity->ancestors()->defaultOrder()->published()->get();

        foreach($ancestors as $ancestor) {
            if ($this->getExtraBreadCrumbFor($ancestor->id)) {
                $crumbs[] = $this->getExtraBreadCrumbFor($ancestor->id);
            }
            $crumb = [];
            $crumb['label'] = $ancestor->title;
            $crumb['href'] = $ancestor->url;

            $crumbs[] = $crumb;
        }

        if ($this->getExtraBreadCrumbFor($this->entity->id)) {
            $crumbs[] = $this->getExtraBreadCrumbFor($this->entity->id);
        }

        return $crumbs;
    }

    private function getExtraBreadCrumbFor($id) {
        // If the page is Library, Archival Collections or Institutional Archives,
        // add "Resources" to the breadcrumbs
        if (in_array($id, [14, 16, 17])) {
            $crumb = [];
            $crumb['label'] = "Resources";
            $crumb['href'] = "/collection/research_resources";

            return $crumb;
        }
    }

    public function navigation()
    {
        $subNav = [];

        foreach($this->entity->children()->orderBy('position')->published()->get() as $item) {
            $element = [
                'href'  => $item->url,
                'label' => $item->title
            ];

            if ($item->id == $this->entity->id) {
                $element['active'] = true;
            }

            $subNav[] = $element;
        }

        if ($this->entity->isRoot()) {
            // Build the nav only with children
            $nav[] = [
                'href'  => $this->entity->url,
                'label' => $this->entity->title,
                'links' => $subNav,
                'active' => true
            ];
        } else {
            // Build it with siblings
            $nav = [];

            foreach($this->entity->parent->children()->orderBy('position')->published()->get() as $element) {
                $item = [
                    'href'  => $element->url,
                    'label' => $element->title,
                ];

                if ($element->id == $this->entity->id) {
                    $item['active'] = true;

                    if (!empty($subNav)) {
                        $item['links']  = $subNav;
                    }
                }

                $nav[] = $item;
            }
        }

        return $nav;
    }

}
