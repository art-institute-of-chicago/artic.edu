<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Models\Exhibition;
use App\Repositories\Api\BaseApiRepository;

class ExhibitionRepository extends BaseApiRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleApiBlocks {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(Exhibition $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateBrowser($object, $fields, 'events', 'position', 'Event');
        $this->hydrateBrowser($object, $fields, 'articles', 'position', 'Article');
        $this->hydrateBrowser($object, $fields, 'sponsors', 'position', 'Sponsor');

        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['siteTags'] ?? []);

        $this->updateBrowserApiRelated($object, $fields, ['exhibitions']);
        $this->updateBrowser($object, $fields, 'events');
        $this->updateBrowser($object, $fields, 'articles');

        $this->updateOrderedBelongsTomany($object, $fields, 'sponsors');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events');

        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        $fields['browsers']['events'] = $this->getFormFieldsForBrowser($object, 'events', 'exhibitions_events');
        $fields['browsers']['sponsors'] = $this->getFormFieldsForBrowser($object, 'sponsors', 'exhibitions_events');

        return $fields;
    }

    public function getExhibitionTypesList() {
        return collect($this->model::$exhibitionTypes);
    }

    public function getFormFieldsHandleSlugs($object, $fields)
    {
        unset($fields['slugs']);

        if ($object->slugs != null) {
            foreach ($object->slugs as $slug) {
                if ($slug->active || $object->slugs->where('locale', $slug->locale)->where('active', true)->count() === 0) {
                    $fields['translations']['slug'][$slug->locale] = $object->datahub_id . '-' . $slug->slug;
                }
            }
        }

        return $fields;
    }

}
