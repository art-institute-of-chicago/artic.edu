<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;

class ArtistPresenter extends BasePresenter
{
    public function itemprops() {
        return [
            'sameAs' => $this->entity->ulan_uri,
            'birthPlace' => $this->entity->birth_date,
            'deathPlace' => $this->entity->death_place,
        ];
    }

    protected function augmented()
    {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    protected function collectionFilteredUrl()
    {
        return route('collection', ['artist_ids' => $this->entity->title]);
    }
}
