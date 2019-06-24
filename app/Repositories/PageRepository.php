<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Page;
use App\Repositories\Behaviors\HandleApiRelations;

class PageRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleFiles, HandleRepeaters, HandleApiRelations, HandleTranslations;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeExhibitions', 'position', 'Exhibition');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeEvents', 'position', 'Event');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeFeatures', 'position', 'HomeFeature');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'mainHomeFeatures', 'position', 'HomeFeature');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'secondaryHomeFeatures', 'position', 'HomeFeature');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'collectionFeatures', 'position', 'CollectionFeature');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeShopItems', 'position', 'ShopItem');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'visitTourPages', 'position', 'GenericPage');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'researchResourcesFeaturePages', 'position', 'GenericPage');

        $this->hydrateOrderedBelongsTomany($object, $fields, 'researchResourcesStudyRooms', 'position', 'GenericPage');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'researchResourcesStudyRoomMore', 'position', 'GenericPage');

        $this->hydrateOrderedBelongsTomany($object, $fields, 'articles', 'position', 'Article');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'printedPublications', 'position', 'PrintedPublication');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'digitalPublications', 'position', 'DigitalPublication');

        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        // General
        $this->updateBrowserApiRelated($object, $fields, ['homeShopItems', 'homeExhibitions', 'exhibitionsExhibitions', 'exhibitionsUpcoming', 'exhibitionsUpcomingListing', 'exhibitionsCurrent', 'artCategoryTerms']);

        // Homepage
        $this->updateBrowser($object, $fields, 'homeEvents');
        $this->updateBrowser($object, $fields, 'homeFeatures');
        $this->updateBrowser($object, $fields, 'mainHomeFeatures');
        $this->updateBrowser($object, $fields, 'secondaryHomeFeatures');
        $this->updateBrowser($object, $fields, 'collectionFeatures');

        // Visits
        $this->updateRepeater($object, $fields, 'admissions', 'Admission');
        $this->updateRepeater($object, $fields, 'locations', 'Location');
        $this->updateRepeater($object, $fields, 'featured_hours', 'FeaturedHour');
        $this->updateRepeater($object, $fields, 'dining_hours', 'DiningHour');
        $this->updateRepeater($object, $fields, 'faqs', 'Faq');
        $this->updateRepeater($object, $fields, 'families', 'Family');
        $this->updateBrowser($object, $fields, 'visitTourPages');

        // Articles
        $this->updateBrowser($object, $fields, 'articlesArticles');

        // Article Categories
        $this->updateBrowser($object, $fields, 'articlesCategories');

        // Art & Ideas
        // $this->updateBrowser($object, $fields, 'artArticles');
        $this->updateMultiBrowserApiRelated($object, $fields, 'featured_items', [
            'articles' => false,
            'interactiveFeatures.experiences' => false
        ]);

        // Research
        $this->updateBrowser($object, $fields, 'researchResourcesFeaturePages');
        $this->updateBrowser($object, $fields, 'researchResourcesStudyRooms');
        $this->updateBrowser($object, $fields, 'researchResourcesStudyRoomMore');

        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowser($object, $fields, 'printedPublications');
        $this->updateBrowser($object, $fields, 'digitalPublications');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        // Homepage
        $fields['browsers']['homeExhibitions'] = $this->getFormFieldsForBrowserApi($object, 'homeExhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');
        $fields['browsers']['homeEvents'] = $this->getFormFieldsForBrowser($object, 'homeEvents', 'exhibitions_events', 'title', 'events');
        $fields['browsers']['homeShopItems'] = $this->getFormFieldsForBrowserApi($object, 'homeShopItems', 'App\Models\Api\ShopItem', 'general');
        $fields['browsers']['homeFeatures'] = $this->getFormFieldsForBrowser($object, 'homeFeatures', 'homepage', 'title', 'homeFeatures');
        $fields['browsers']['mainHomeFeatures'] = $this->getFormFieldsForBrowser($object, 'mainHomeFeatures', 'homepage', 'title', 'homeFeatures');
        $fields['browsers']['secondaryHomeFeatures'] = $this->getFormFieldsForBrowser($object, 'secondaryHomeFeatures', 'homepage', 'title', 'homeFeatures');
        $fields['browsers']['collectionFeatures'] = $this->getFormFieldsForBrowser($object, 'collectionFeatures', 'homepage', 'title', 'collectionFeatures');

        // Exhibition & Events
        $fields['browsers']['exhibitionsUpcomingListing'] = $this->getFormFieldsForBrowserApi($object, 'exhibitionsUpcomingListing', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');
        $fields['browsers']['exhibitionsExhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitionsExhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');
        $fields['browsers']['exhibitionsCurrent'] = $this->getFormFieldsForBrowserApi($object, 'exhibitionsCurrent', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');
        $fields['browsers']['exhibitionsUpcoming'] = $this->getFormFieldsForBrowserApi($object, 'exhibitionsUpcoming', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');

        // Visits
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'admissions', 'Admission');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'locations', 'Location');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'featured_hours', 'FeaturedHour');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'dining_hours', 'DiningHour');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'faqs', 'Faq');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'families', 'Family');
        $fields['browsers']['visitTourPages'] = $this->getFormFieldsForBrowser($object, 'visitTourPages', 'generic', 'title', 'genericPages');

        // Articles
        $fields['browsers']['articlesArticles'] = $this->getFormFieldsForBrowser($object, 'articlesArticles', 'collection.articles_publications', 'title', 'articles');

        // Article Categories
        $fields['browsers']['articlesCategories'] = $this->getFormFieldsForBrowser($object, 'articlesCategories', 'collection.articles_publications', 'name', 'categories');

        // Art & Ideas
        // $fields['browsers']['artArticles'] = $this->getFormFieldsForBrowser($object, 'artArticles', 'collection.articles_publications', 'title', 'articles');
        $fields['browsers']['artCategoryTerms'] = $this->getFormFieldsForBrowserApi($object, 'artCategoryTerms', 'App\Models\Api\CategoryTerm', 'collection', 'title', 'categoryTerms');
        $fields['browsers']['featured_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'featured_items', [

        ], [ 
            'articles' => false,
            'interactiveFeatures.experiences' => false
        ]);

        // Research
        $fields['browsers']['researchResourcesFeaturePages'] = $this->getFormFieldsForBrowser($object, 'researchResourcesFeaturePages', 'generic', 'title', 'genericPages');
        $fields['browsers']['researchResourcesStudyRooms'] = $this->getFormFieldsForBrowser($object, 'researchResourcesStudyRooms', 'generic', 'title', 'genericPages');
        $fields['browsers']['researchResourcesStudyRoomMore'] = $this->getFormFieldsForBrowser($object, 'researchResourcesStudyRoomMore', 'generic', 'title', 'genericPages');

        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications', 'title', 'articles');
        $fields['browsers']['printedPublications'] = $this->getFormFieldsForBrowser($object, 'printedPublications', 'collection.articles_publications', 'title', 'printedPublications');
        $fields['browsers']['digitalPublications'] = $this->getFormFieldsForBrowser($object, 'digitalPublications', 'collection.articles_publications', 'title', 'digitalPublications');

        return $fields;
    }

    public function byName($name, $with = [])
    {
        $type = array_search($name, $this->model::$types);
        return $this->model->whereType($type)->with($with)->first();
    }
}
