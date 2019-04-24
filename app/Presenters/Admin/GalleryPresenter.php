<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;

class GalleryPresenter extends BasePresenter
{
    protected function augmented()
    {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    protected function collectionFilteredUrl()
    {
        return route('collection', [
            'gallery_ids' => $this->entity->id,
            'is_on_view' => true,
        ]);
    }
}
