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
        // Replace all MagazineItems associated with this MagazineIssue by filtering blocks
        $object->magazineItems()->delete();

        $this->getBlocks($object, $fields)
            ->where('type', '=', 'magazine_item')
            ->values()
            ->each(function ($block, $key) use ($object) {
                $featureType = $block['content']->feature_type;

                $magazineItem = new MagazineItem([
                    'position' => $key,
                    'feature_type' => $featureType,

                    // Only for custom magazine items
                    'tag' => $block['content']->tag ?? null,
                    'title' => $block['content']->title ?? null,
                    'list_description' => $block['content']->list_description ?? null,
                    'url' => $block['content']->url ?? null,
                ]);

                $magazineItem->magazineIssue()->associate($object);

                if ($magazinableClass = MagazineItem::getClassFromType($featureType)) {
                    if ($magazinableItem = $magazinableClass::find($block['browsers'][$featureType][0]['id'])) {
                        $magazineItem->magazinable()->associate($magazinableItem);
                    }
                }

                $magazineItem->save();
            });

        parent::afterSave($object, $fields);
    }
}

