<?php

namespace App\Repositories;

use A17\Twill\Repositories\MediaRepository as BaseMediaRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Models\PublicationMedia;

class PublicationMediaRepository extends BaseMediaRepository
{
    public function __construct(PublicationMedia $model)
    {
        $this->model = $model;
    }

    public function afterDelete($object)
    {
        $storageId = $object->uuid;
        if (Config::get('twill.media_library.cascade_delete')) {
            Storage::disk(Config::get('twill.publication_media_library.disk'))->delete($storageId);
        }
    }
}
