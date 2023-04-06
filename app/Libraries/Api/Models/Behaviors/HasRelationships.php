<?php

namespace App\Libraries\Api\Models\Behaviors;

use App\Libraries\Api\Builders\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasRelationships
{
    /**
     * The loaded relationships for the model.
     *
     * @var array
     */
    protected $relations = [];

    /**
     * Set the specific relationship in the model.
     *
     * @param  string  $relation
     * @param  mixed  $value
     * @return $this
     */
    public function setRelation($relation, $value)
    {
        $this->relations[$relation] = $value;

        return $this;
    }

    /**
     * Define a one-to-many relationship. On this case we just load all ids coming
     * from the API
     *
     * @param  string  $related
     * @param  string  $localKey
     * @return App\Libraries\Api\Builders\Relations\HasMany
     */
    public function hasMany($related, $localKey = 'id', $limit = -1)
    {
        $queryInstance = $related::query();

        // If we have no data in our localKey we ignore the relationship to
        // avoid calling to an endpoint with no data
        if (empty($this->{$localKey})) {
            return;
        }

        return $this->newHasMany(
            $queryInstance,
            $this,
            $localKey,
            $limit
        );
    }

    /**
     * Instantiate a new HasMany relationship.
     *
     * @param  App\Libraries\Api\Builders\ApiQueryBuilder $query
     * @param  App\Libraries\Api\Models\BaseApiModel; $parent
     * @param  string  $localKey
     * @return App\Libraries\Api\Builders\Relations\HasMany
     */
    protected function newHasMany($query, $parent, $localKey, $limit)
    {
        return new HasMany($query, $parent, $localKey, $limit);
    }

    /**
     * Get a relationship.
     *
     * @param  string $key
     * @return mixed
     */
    public function getRelationValue($key)
    {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        if (method_exists($this, $key)) {
            return $this->getRelationshipFromMethod($key);
        }
    }

    protected function getRelationshipFromMethod($method)
    {
        $relation = $this->{$method}();

        if (!$relation) { // Empty relationships return null to avoid calling the API
            return null;
        }

        return tap($relation->get(), function ($results) use ($method) {
            $this->setRelation($method, $results);
        });
    }

    /**
     * Determine if the given relation is loaded.
     *
     * @param  string  $key
     * @return bool
     */
    public function relationLoaded($key)
    {
        return array_key_exists($key, $this->relations);
    }

    public function getMorphClass()
    {
        $morphMap = Relation::morphMap();

        if (!empty($morphMap) && in_array(static::class, $morphMap)) {
            return array_search(static::class, $morphMap, true);
        }

        return static::class;
    }
}
