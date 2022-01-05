<?php

namespace App\Libraries\Api\Models\Behaviors;

use App\Libraries\Api\Builders\Connection\AicConnection;
use App\Libraries\Api\Builders\ApiModelBuilder;
use App\Libraries\Api\Builders\ApiQueryBuilder;

trait HasApiCalls
{

    /**
     * The array of default scopes on the model.
     *
     * @var array
     */
    protected static $defaultScopes = [];

    /**
     * Begin querying a model with eager loading.
     *
     * @param  array|string $relations
     * @return App\Libraries\Api\Builders\ApiModelBuilder
     */
    public static function with($relations)
    {
        return (new static())->newQuery()->with(
            is_string($relations) ? func_get_args() : $relations
        );
    }

    /**
     * Begin querying the model.
     *
     * @return App\Libraries\Api\Builders\ApiModelBuilder
     */
    public static function query()
    {
        return (new static())->newQuery();
    }

    /**
     * Begin querying the model.
     *
     * @return App\Libraries\Api\Builders\ApiModelBuilder
     */
    public static function search($value)
    {
        return (new static())->newQuery()->search($value);
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @return App\Libraries\Api\Builders\ApiModelBuilder
     */
    public function newQuery()
    {
        return $this->registerDefaultScopes($this->newQueryWithoutScopes());
    }

    /**
     * Register the global scopes for this builder instance.
     *
     * @param  App\Libraries\Api\Builders\ApiModelBuilder $builder
     * @return App\Libraries\Api\Builders\ApiModelBuilder
     */
    public function registerDefaultScopes($builder)
    {
        foreach ($this->getDefaultScopes() as $name => $parameters) {
            if (empty($parameters)) {
                $builder->{$name}();
            } else {
                $builder->{$name}($parameters);
            }
        }

        return $builder;
    }

    /**
     * Get the default scopes for this class instance.
     *
     * @return array
     */
    public function getDefaultScopes()
    {
        return static::$defaultScopes;
    }

    /**
     * Get a new query builder that doesn't have any global scopes.
     *
     * @return App\Libraries\Api\Builders\ApiModelBuilder|static
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
        return new AicConnection();
    }

    /**
     * Parse API endpoint. Replace brackets {name} with the 'name' attribute value (usually datahub_id)
     *
     * This way you can define an endpoint like:
     * protected $endpoint = '/api/v1/exhibitions/{datahub_id}/artwork/{id}';
     *
     * And the elements will be dinamically replaced with the params values passed
     *
     * @return string
     */
    public function parseEndpoint($type, $params = [])
    {
        return preg_replace_callback('!\{(\w+)\}!', function ($matches) use ($params) {
            $name = $matches[1];

            return $params[$name];
        }, $this->getEndpoint($type));
    }
}
