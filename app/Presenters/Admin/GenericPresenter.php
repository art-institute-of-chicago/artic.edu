<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class GenericPresenter extends BasePresenter
{

    public function presentPublishStartDate() {
        if ($this->entity->publish_start_date) {
            if (!empty($this->entity->publish_start_date)) {
                return $this->entity->publish_start_date->format('m d Y');
            }
        }

        return "No";
    }

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
            $crumb = [];
            $crumb['label'] = $ancestor->title;
            $crumb['href'] = $ancestor->url;

            $crumbs[] = $crumb;
        }

        return $crumbs;
    }

    public function navigation()
    {
        $subNav = [];
        foreach($this->entity->children()->published()->defaultOrder()->get() as $item) {
            $subNav[] = [
                'href' => $item->url,
                'label' => $item->title
            ];
        }

        if ($this->entity->isRoot()) {
            // Build the nav only with children
            $nav[] = [
                'href'  => $this->entity->url,
                'label' => $this->entity->title,
                'links' => $subNav
            ];
        } else {
            // Build it with siblings
            $nav = [];

            foreach($this->entity->parent->children as $element) {
                $item = [
                    'href'  => $element->url,
                    'label' => $element->title,
                ];

                if ($element->id == $this->entity->id && !empty($subNav)) {
                    $item['links'] = $subNav;
                }

                $nav[] = $item;
            }
        }

        return $nav;
    }

}
