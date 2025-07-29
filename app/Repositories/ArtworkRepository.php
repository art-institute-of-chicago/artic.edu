<?php

namespace App\Repositories;

use App\Jobs\TileMedia;
use App\Models\Artwork;
use App\Models\Api\TextEmbedding;
use A17\Twill\Models\Media;
use A17\Twill\Models\Contracts\TwillModelContract;
use App\Repositories\Behaviors\HandleFeaturedRelated;
use App\Repositories\Behaviors\Handle3DModel;
use App\Repositories\Api\BaseApiRepository;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use Illuminate\Support\Facades\DB;

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

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        $this->handle3DModel($object, $fields);

        $iiifMediaId = $fields['medias']['iiif'][0]['id'] ?? null;

        if ($iiifMediaId) {
            $iiifMedia = Media::find($iiifMediaId);

            if ($iiifMedia) {
                TileMedia::dispatch($iiifMedia, $fields['force_iiif_regenerate'] ?? false);
            }
        }

        if (isset($fields['semantic_search_description'])) {
            $description = $fields['semantic_search_description'];
            $embedding = TextEmbedding::firstOrCreate(
                [
                    'model_name' => 'artworks',
                    'model_id'   => $object->datahub_id,
                ],
                [
                    'data' => [],
                ]
            );

            $currentData = $embedding->data ?? [];
            $newData = array_merge($currentData, ['description' => $description]);

            $embedding->update(['data' => $newData]);

            DB::connection('vectors')->table('embedding_updates')->insert(
                [
                'created_at' => now(),
                'embedding_type' => 'text',
                'model_name' => 'artworks',
                'model_id' => $object->datahub_id,
                ]
            );
        }

        parent::afterSave($object, $fields);
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);

        $fields = $this->getFormFieldsFor3DModel($object, $fields);

        if (request()->input('showAIData') === 'true') {
            $object->semantic_search_description = $object->getSemanticSearchDescriptionAttribute();
        }

        return $fields;
    }
}
