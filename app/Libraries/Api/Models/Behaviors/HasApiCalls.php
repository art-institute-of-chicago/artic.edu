<?php

namespace App\Libraries\Api\Models\Behaviors;

// TODO: Redefine how to load these libraries in a configurable way
// Also setup a system to deal with different endpoints.

use App\Libraries\Api\Builders\Connection\AicConnection;
use App\Libraries\Api\Builders\ApiModelBuilder;
use App\Libraries\Api\Builders\ApiQueryBuilder;

trait HasApiCalls
{

    /**
     * Begin querying a model with eager loading.
     *
     * @param  array|string  $relations
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function with($relations)
    {
        return (new static)->newQuery()->with(
            is_string($relations) ? func_get_args() : $relations
        );
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery()
    {
        return $this->newQueryWithoutScopes();
    }

    /**
     * Get a new query builder that doesn't have any global scopes.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newQueryWithoutScopes()
    {
        $builder = $this->newApiModelBuilder($this->newApiQueryBuilder());

        // Once we have the query builders, we will set the model instances so the
        // builder can easily access any information it may need from the model
        // while it is constructing and executing various queries against it.
        return $builder->setModel($this)
                    ->with($this->with);
    }

    public function newApiModelBuilder($query)
    {
        return new ApiModelBuilder($query);
    }

    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newApiQueryBuilder()
    {
        $connection = $this->getConnection();

        return new ApiQueryBuilder($connection, $connection->getQueryGrammar());
    }

    public function getConnection()
    {
        // TODO: Manage this to be changed dynamically
        return new AicConnection($this->endpoint);
    }

    /**
     * Get API endpoint. Replace brackets {name} with the 'name' attribute value (usually datahub_id)
     *
     * This way you can define an endpoint like:
     * protected $endpoint = '/api/v1/exhibitions/{datahub_id}/artwork/{id}';
     *
     * And the elements will be dinamically replaced with eloquent values
     *
     * @return string
     */
    public function getEndpoint()
    {
        return preg_replace_callback('!\{(\w+)\}!', function($matches) {
            $name = $matches[1];
            return $this->$name;
        }, $this->endpoint);
    }

}

