<?php

namespace App\Presenters\Admin;

class PrintedPublicationPresenter extends PagePresenter
{
    public function getCanonicalUrl()
    {
        return route('collection.publications.printed-publications.show', [
            'id' => $this->entity->id,
            'slug' => $this->entity->getSlug(),
        ]);
    }
}
