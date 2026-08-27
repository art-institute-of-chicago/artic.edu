<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class ArtistPresenter extends BasePresenter
{
    public function augmented()
    {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    protected function collectionFilteredUrl()
    {
        return route('collection', ['artist_ids' => $this->entity->title]);
    }
}
