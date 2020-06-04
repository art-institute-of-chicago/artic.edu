<?php

namespace App\Repositories;

use App\Models\MagazineIssue;
use App\Models\MagazineItem;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;

class MagazineIssueRepository extends ModuleRepository
{
    use HandleSlugs, HandleBlocks, HandleMedias, HandleRevisions;

    public function __construct(MagazineIssue $model)
    {
        $this->model = $model;
    }


    public function afterSave($object, $fields)
    {
        $this->syncMagazineItems($object, $fields);

        parent::afterSave($object, $fields);
    }

    /**
     * Replace all MagazineItems associated with this MagazineIssue by filtering blocks
     */
    private function syncMagazineItems($object, $fields)
    {
        $object->magazineItems()->delete();

        $this->getBlocks($object, $fields)
            ->filter(function ($block, $key) {
                return $block['type'] === 'magazine_item'
                    && $block['content']->feature_type !== MagazineItem::ITEM_TYPE_CUSTOM;
            })
            ->values()
            ->each(function ($block, $key) use ($object) {
                $featureType = $block['content']->feature_type;

                $magazineItem = new MagazineItem([
                    'position' => $key,
                    'feature_type' => $featureType,
                    'list_description' => $block['content']->list_description ?? null,
                ]);

                $magazineItem->magazineIssue()->associate($object);

                if ($magazinableClass = MagazineItem::getClassFromType($featureType)) {
                    if ($magazinableItem = $magazinableClass::find($block['browsers'][$featureType][0]['id'])) {
                        $magazineItem->magazinable()->associate($magazinableItem);
                    }
                }

                $magazineItem->save();
            });
    }

}

