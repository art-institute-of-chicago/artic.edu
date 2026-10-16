<?php

namespace App\Repositories\Behaviors;

use A17\Twill\Models\Contracts\TwillModelContract;

/**
 * Manual curation for the artwork Publications and Exhibitions sections, which
 * take precedence over (and merge with) the auto-derived items.
 */
trait HandleArtworkSections
{
    public function afterSaveHandleArtworkSections(TwillModelContract $object, array $fields): void
    {
        $this->updateMultiBrowserApiRelated($object, $fields, 'artwork_publications', [
            'digitalPublications' => false,
            'printedPublications' => false,
            'digitalPublicationArticles' => false,
        ]);

        $this->updateMultiBrowserApiRelated($object, $fields, 'artwork_exhibitions', [
            'exhibitions' => true,
        ]);

        $this->updateMultiBrowserApiRelated($object, $fields, 'artwork_educator_resources', [
            'educatorResources' => false,
        ]);
    }

    public function getFormFieldsHandleArtworkSections(TwillModelContract $object, array $fields): array
    {
        $fields['browsers']['artwork_publications'] = $this->getFormFieldsForMultiBrowserApi(
            $object,
            'artwork_publications',
            [],
            [
                'digitalPublications' => false,
                'printedPublications' => false,
                'digitalPublicationArticles' => false,
            ]
        );

        $fields['browsers']['artwork_exhibitions'] = $this->getFormFieldsForMultiBrowserApi(
            $object,
            'artwork_exhibitions',
            [
                'exhibitions' => [
                    'apiModel' => 'App\Models\Api\Exhibition',
                    'routePrefix' => 'exhibitionsEvents',
                    'moduleName' => 'exhibitions',
                ],
            ],
            [
                'exhibitions' => true,
            ]
        );

        $fields['browsers']['artwork_educator_resources'] = $this->getFormFieldsForMultiBrowserApi(
            $object,
            'artwork_educator_resources',
            [],
            [
                'educatorResources' => false,
            ]
        );

        return $fields;
    }
}
