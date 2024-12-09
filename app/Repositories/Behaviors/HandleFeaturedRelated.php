<?php

namespace App\Repositories\Behaviors;

/**
 * WEB-1415: For sidebar related item multiselect.
 */
trait HandleFeaturedRelated
{
    public function afterSaveHandleFeaturedRelated($object, $fields): void
    {
        $this->updateMultiBrowserApiRelated($object, $fields, 'sidebar_items', [
            'articles' => false,
            'highlights' => false,
            'events' => false,
            'experiences' => false,
            'digitalPublications' => false,
            'digitalPublicationArticles' => false,
            'videos' => false,
            'exhibitions' => true,
        ]);
    }

    public function getFormFieldsHandleFeaturedRelated($object, $fields): array
    {
        $fields['browsers']['sidebar_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'sidebar_items', [
            'exhibitions' => [
                'apiModel' => 'App\Models\Api\Exhibition',
                'routePrefix' => 'exhibitions_events',
                'moduleName' => 'exhibitions',
            ],
        ], [
            'articles' => false,
            'highlights' => false,
            'events' => false,
            'experiences' => false,
            'digitalPublications' => false,
            'digitalPublicationArticles' => false,
            'videos' => false,
            'exhibitions' => true,
        ]);

        return $fields;
    }
}
