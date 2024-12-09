<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\PrintedPublication;

class PrintedPublicationRepository extends ModuleRepository
{
    use HandleBlocks;
    use HandleSlugs;
    use HandleMedias;
    use HandleFiles;
    use HandleRevisions;

    public function __construct(PrintedPublication $model)
    {
        $this->model = $model;
    }

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        $object->categories()->sync($fields['categories'] ?? []);
        parent::afterSave($object, $fields);
    }

    public function getShowData($item, $slug = null, $previewPage = null)
    {
        return [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'subNav' => null,
            'nav' => null,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'breadcrumb' => [],
            'blocks' => null,
            'nav' => [],
            'page' => $item,

        ];
    }
}
