<?php

namespace App\Libraries\Api\Builders\Relations;

class HasMany
{
    /**
     * The local key of the parent model.
     *
     * @var string
     */
    protected $localKey;

    /**
     * The ApiQueryBuilder instance.
     *
     * @var App\Libraries\Api\Builders\ApiQueryBuilder;
     */
    protected $query;

    /**
     * The parent model instance.
     *
     * @var App\Libraries\Api\Models\BaseApiModel;
     */
    protected $parent;

    public function __construct($query, $parent, $localKey)
    {
        $this->query    = $query;
        $this->parent   = $parent;
        $this->localKey = $localKey;

        $this->addConstraints();
    }

    public function addConstraints()
    {
        // On this case we just save the Id's array coming from the API
        // And pass it to the query to filter by ID.
        $ids = $this->parent->{$this->localKey};

        // Sometimes it's just an id and not an array
        $ids = is_array($ids) ? $ids : [$ids];

        $this->query->ids($ids);
    }

    /**
     * Execute eager loading.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEager()
    {
        return $this->get();
    }

    /**
     * Execute the query
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get($columns = [])
    {
       return $this->query->get($columns);
    }
}
