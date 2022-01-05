<?php

namespace App\Models\Behaviors;

/**
 * Trait used to augment the local entity with Data coming from the API.
 * This is only to be used at the CMS when editing an augmented resource
 * in order to show all API data as well.
 *
 */

trait HasApiModel
{
    /**
     * Indicates if the fields have been refresh using the API
     *
     * @var bool
     */
    private $apiFilled = false;

    /**
     * Store the API fields information
     *
     * @var bool
     */
    private $apiFields = [];

    /**
     * Helper to prevent duplicate API queries.
     */
    private $apiDataCache;

    /**
     * Refresh the model with API values in case it's not done yet.
     *
     * @var array
     */
    public function refreshApi()
    {
        if (!$this->apiFilled) {
            // Load the API model and setup all fields
            $dataObject = $this->getApiModelFilled();

            // Augment the entity with the object fields
            $this->augmentEntity($dataObject->toArray());

            // Mark the entity as augmented to avoid double calls
            $this->apiFilled = true;
        }

        return $this;
    }

    public function getApiModelFilled()
    {
        return $this->apiDataCache = $this->apiModel::query()->find($this->datahub_id);
    }

    public function getApiModelFilledCached()
    {
        return $this->apiDataCache ?? $this->getApiModelFilled();
    }

    public function getApiModel()
    {
        return $this->apiModel;
    }

    /**
     * WEB-1315: When an item from the API gets augmented, the website
     * takes all the data coming from the API, and uses it to fill out
     * a new model instance. If there are any name collisions between
     * API fields and model fields (e.g. title), API data will be saved
     * to the model permanently. This causes API changes to appear not
     * to propogate to the website. It seems like this is only the case
     * with `title`, so here is a work-around for that bug.
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->getApiModelFilledCached()->title ?? $this->attributes['title'] ?? null;
    }

    /**
     * Augment the entity with the values coming from the API.
     * TODO: Solve name collisions
     *
     * @object
     */
    public function augmentEntity($dataObject)
    {
        foreach ($dataObject as $key => $value) {
            if ($this->hasAttribute($key)) {
                // TODO: If the attribute already exists un-tie with a mapping array and set the attr.
                // Something like ['id' => 'datahub_id']
            } else {
                $this->setAttribute($key, $value);
                array_push($this->apiFields, $key);
            }
        }

        // Mark the entity as augmented to avoid double calls
        $this->apiFilled = true;
    }

    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }

    public function getApiField($field)
    {
        return $this->getApiFields[$field];
    }

    /**
     * Get API fields and its values stored at the object
     *
     * @return object
     */
    public function getApiFields()
    {
        return (object) array_reduce($this->apiFields, function ($result, $field) {
            $result[$field] = $this->{$field};

            return $result;
        }, []);
    }
}
