<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class GalleryPresenter extends BasePresenter
{
    public function augmented()
    {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    protected function collectionFilteredUrl()
    {
        return route('collection', [
            'gallery_ids' => $this->entity->id,
        ]);
    }
}
