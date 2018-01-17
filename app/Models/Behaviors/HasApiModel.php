<?php

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

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
        return $this->apiModel::query()->find($this->datahub_id);
    }

    public function getApiModel()
    {
        return $this->apiModel;
    }

    /**
     * Augment the entity with the values coming from the API.
     * TODO: Solve name collisions
     *
     * @object
     */
    public function augmentEntity($dataObject)
    {
        foreach($dataObject as $key => $value) {
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
        return (object) array_reduce($this->apiFields, function($result, $field) {
            $result[$field] = $this->$field; return $result;
        }, array());
    }

}
