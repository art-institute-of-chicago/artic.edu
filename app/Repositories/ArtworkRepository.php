<?php

namespace App\Repositories;

use App\Models\Artwork;
use App\Jobs\TileMedia;
use A17\Twill\Models\Media;
use App\Repositories\Behaviors\HandleFeaturedRelated;
use App\Repositories\Behaviors\Handle3DModel;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use App\Repositories\Api\BaseApiRepository;
use A17\Twill\Repositories\Behaviors\HandleFiles;

class ArtworkRepository extends BaseApiRepository
{
    use HandleFeaturedRelated;
    use Handle3DModel;
    use HandleMedias;
    use HandleFiles;

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->handle3DModel($object, $fields);

        $iiifMediaId = $fields['medias']['iiif'][0]['id'] ?? null;

        if ($iiifMediaId) {
            $iiifMedia = Media::find($iiifMediaId);
            if ($iiifMedia) {
                TileMedia::dispatch($iiifMedia, $fields['force_iiif_regenerate'] ?? false);
            }
        }

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields = $this->getFormFieldsFor3DModel($object, $fields);

        return $fields;
    }
}
