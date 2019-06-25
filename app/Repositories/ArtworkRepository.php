<?php

namespace App\Repositories;

use App\Models\Artwork;
use App\Repositories\Api\BaseApiRepository;

class ArtworkRepository extends BaseApiRepository
{

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowserApiRelated($object, $fields, ['sidebarExhibitions']);
        $this->updateBrowser($object, $fields, 'sidebarInteractiveFeatures');
        $this->updateBrowser($object, $fields, 'sidebarEvent');
        $this->updateBrowser($object, $fields, 'sidebarArticle');
        $this->updateBrowser($object, $fields, 'videos');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['sidebarExhibitions'] = $this->getFormFieldsForBrowserApi($object, 'sidebarExhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');
        $fields['browsers']['sidebarInteractiveFeatures'] = $this->getFormFieldsForBrowser($object, 'experiences', 'collection');
        $fields['browsers']['videos'] = $this->getFormFieldsForBrowser($object, 'videos', 'collection.articles_publications');
        $fields['browsers']['sidebarEvent'] = $this->getFormFieldsForBrowser($object, 'sidebarEvent', 'exhibitions_events', 'title', 'events');
        $fields['browsers']['sidebarArticle'] = $this->getFormFieldsForBrowser($object, 'sidebarArticle', 'collection.articles_publications', 'title', 'articles');

        return $fields;
    }

    public function getFormFieldsForBrowser($object, $relation, $routePrefix = null, $titleKey = 'title', $moduleName = null)
    {
        if ($relation === 'experiences') {
            return $object->$relation->map(function ($relatedElement) use ($titleKey, $routePrefix, $relation, $moduleName) {
                return [
                    'id' => $relatedElement->id,
                    'name' => $relatedElement->titleInBrowser ?? $relatedElement->$titleKey,
                    'edit' => '',
                    'endpointType' => $relatedElement->getMorphClass(),
                ] + (classHasTrait($relatedElement, HasMedias::class) ? [
                    'thumbnail' => $relatedElement->defaultCmsImage(['w' => 100, 'h' => 100]),
                ] : []);
            })->toArray();
        } else {
            return parent::getFormFieldsForBrowser($object, $relation, $routePrefix, $titleKey, $moduleName);
        }
    }

}
