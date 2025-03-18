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

    public function type()
    {
        return \Illuminate\Support\Str::title(\Illuminate\Support\Str::replace('_', ' ', $this->entity->type));
    }
}
