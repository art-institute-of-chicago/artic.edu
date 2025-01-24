<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class ArtistPresenter extends BasePresenter
{
    public function itemprops()
    {
        return [
            'sameAs' => $this->entity->ulan_uri,
            'birthPlace' => $this->entity->birth_place,
            'deathPlace' => $this->entity->death_place,
        ];
    }

    public function augmented()
    {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    protected function collectionFilteredUrl()
    {
        return route('collection', ['artist_ids' => $this->entity->title]);
    }
}
