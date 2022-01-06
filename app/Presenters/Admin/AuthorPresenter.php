<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class AuthorPresenter extends BasePresenter
{
    public function intro()
    {
        return $this->entity->description;
    }

    public function url()
    {
        return route('authors.show', [$this->entity->id, $this->entity->getSlug()]);
    }

    public function getRelatedWritings()
    {
        if (!isset($this->writingsCache)) {
            $this->loadRelatedWritings();
        }

        return $this->writingsCache;
    }

    public function loadRelatedWritings()
    {
        $writings = [];

        foreach (['articles', 'highlights', 'experiences', 'issueArticles'] as $relation) {
            if ($this->{$relation}) {
                $writings[] =
                    $this->{$relation}
                        ->map(function ($element) use ($relation) {
                            return $this->_prepWriting($element, $relation);
                        });
            }
        }


        return $this->writingsCache = collect($writings)->flatten(1)->filter()->sortByDesc('date');
    }

    private function _prepWriting($element, $type = 'article')
    {
        $element->date = $element->date ?? $element->publish_start_date ?? $element->updated_at;
        $element->writingType = $type;

        if ($element->isNotUnlisted === false) {
            return false;
        }
        if ($element->isPublished === false) {
            return false;
        }

        return $element;
    }
}
