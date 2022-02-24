<?php

namespace App\Http\Controllers;

/**
 * Quick and oversimplified implementation of Ruby on Rails has_scope gem.
 *
 * Basic functionality: We setup a base chainable object, usually an Eloquent Query Builder,
 * on this case it's an API Query Builder (beginOfAssociationChain).
 * Once we have that we define relationships between URL parameters and scopes at the $scopes variable.
 * The controller apply the scopes to the base chain checking that the attribute is present at the
 * url, and sends the attribute value as a parameter to the scope call.
 * This way we create an easy way of chaining scopes dynamically.
 */
class BaseScopedController extends FrontController
{
    protected $entity;

    /**
     * Collection resultset memoization
     */
    protected $collection;

    /**
     * Default elements per page
     */
    const PER_PAGE = 20;

    /**
     * Define here the set of rules to apply scopes
     * The key is the expected parameter
     * The value is the scope to be executed on the chain
     *
     * [ parameter => scopeName, .... ]
     *
     * Scopes should better be defined on each controller but given we use this
     * on 3 places (general search, collections and artwork prev/next functionality)
     * better to place them here to have a single control point
     */
    protected $scopes = [
        'q' => 'search',
        'artist_ids' => 'byArtists',
        'style_ids' => 'byStyles',
        'subject_ids' => 'bySubjects',
        'material_ids' => 'byMaterials',
        'place_ids' => 'byPlaces',
        'artwork_type_id' => 'byArtworkType',
        'color' => 'byColor',
        'sort_by' => 'sortBy',
        'date-start' => 'yearMin',
        'date-end' => 'yearMax',
        'is_on_view' => 'onView',
        'classification_ids' => 'byClassifications',
        'department_ids' => 'byDepartments',
        'is_public_domain' => 'publicDomain',
        'is_recent_acquisition' => 'recentAcquisition',
        'has_multimedia' => 'hasMultimedia',
        'has_educational_resources' => 'hasEducationalResources',

        // Hidden from filters but present in Quick facets
        'theme_ids' => 'byThemes',
        'gallery_ids' => 'byGalleryIdsOnView',
        'technique_ids' => 'byTechniques',
    ];

    /**
     * Returns the processed collection.
     * Function added to allow redefinition and add custom scopes at the end
     */
    protected function collection()
    {
        if (!$this->collection) {
            $this->collection = $this->endOfAssociationChain();
        }

        return $this->collection;
    }

    /**
     * Returns the chain to be used as a collection
     * Usually a type that responds to query builder behavior
     *
     * Redefine this function if you define an entity different than
     * an eloquent model
     *
     * Example:
     * $entity = \App\Models\Post::class;
     */
    protected function beginOfAssociationChain()
    {
        $model = new $this->entity();
        $builder = $model->newQuery();

        return $builder;
    }

    /**
     * Returns the chain with all scopes applied to it
     */
    protected function endOfAssociationChain()
    {
        $base = $this->beginOfAssociationChain();

        return $this->applyScopes($base);
    }

    /**
     * Apply all present scopes to the passed builder.
     * It receives the chain as a parameter.
     * Usually just an Eloquent query builder.
     *
     * For example, on AIC is a custom Collection class that accepts scopes
     * with an underline API query builder.
     */
    protected function applyScopes($query)
    {
        if (!empty($this->scopes)) {
            foreach ($this->scopes as $parameter => $scope) {
                if (request()->input($parameter) != null) {
                    $query->{$scope}(request()->input($parameter));
                }
            }
        }

        return $query;
    }

    /**
     *
     * Returns a boolean indicating if any scope is present
     */
    protected function hasAnyScope()
    {
        if (empty($this->scopes)) {
            return true;
        }
            foreach ($this->scopes as $parameter => $scope) {
                if (request()->input($parameter) != null) {
                    return true;
                }
            }



    }
}
