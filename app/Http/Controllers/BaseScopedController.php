<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

/**
 * Quick and oversimplified implementation of Ruby on Rails has_scope gem.
 * Apply scopes to the chain depending on the parameters received at the request.
 *
 */

class BaseScopedController extends FrontController
{
    protected $entity;

    // Collection resultset memoization
    protected $collection;

    // Default elements per page
    const PER_PAGE = 20;

    /**
     * Define here the set of rules to apply scopes
     * The key is the expected parameter
     * The value is the scope to be executed on the chain
     *
     * [ parameter => scopeName, .... ]
     *
     */
    protected $scopes = [];

    /**
     * Returns the processed collection.
     * Function added to allow redefinition and add custom scopes at the end
     *
     */
    protected function collection()
    {
        if (!$this->collection)
            $this->collection = $this->endOfAssociationChain();

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
     *
     */
    protected function beginOfAssociationChain()
    {
        $model   = new $this->entity;
        $builder = $model->newQuery();

        return $builder;
    }

    /**
     * Returns the chain with all scopes applied to it
     *
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
     *
     */
    protected function applyScopes($query)
    {
        if (!empty($this->scopes)) {
            foreach ($this->scopes as $parameter => $scope) {
                if (request()->input($parameter) != null) {
                    $query->$scope(request()->input($parameter));
                }
            }
        }

        return $query;
    }

}
