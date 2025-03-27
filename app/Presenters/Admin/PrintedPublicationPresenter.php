<?php

namespace App\Presenters\Admin;
use Illuminate\Support\Str;

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
        return Str::title(Str::replace('_', ' ', $this->entity->type));
    }
}
