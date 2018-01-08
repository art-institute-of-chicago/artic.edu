<?php

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

namespace App\Models\Behaviors;

trait HasApiSource
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
     * Indicates if there was any error while loading the API
     *
     * @var bool
     */
    private $apiError = false;

    /**
     * Refresh the model with API values in case it's not done yet.
     *
     * @var array
     */
    public function refreshApi($params = [])
    {
        if (!$this->apiFilled) {
            if ($this->hasAllApiParameters()) {
                // Load the API endpoint and setup all fields
                $dataObject = $this->request($params);

                if ($dataObject->status == 200) {
                    // Augment the entity with the object fields
                    $this->augmentEntity($dataObject->body->data);

                    // Mark the entity as augmented to avoid double calls
                    $this->apiFilled = true;
                } else {
                    $this->apiError = true;
                    $message = $this->getEndpoint() . ' - Status: ' . $dataObject->body->status . " \n";
                    $message .= get_class($this) . " with ID: " . $this->id . ". " . $dataObject->body->detail;
                    \Log::error($message);
                }
            } else {
                $this->apiError = true;

                $message = get_class($this) . " with ID: " . $this->id . " doesn't have all API parameters filled. Check the endpoint and needed fields";
                \Log::error($message);
            }
        }
        return $this;
    }

    /**
     * Augment the entity with the values coming from the API.
     * TODO: Solve name collisions
     *
     * @object
     */
    public function augmentEntity($dataObject) {
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

    /**
     * Detect all parameters are present to avoid calls to a wrong API endpoint
     *
     * @return boolean
     */
    protected function hasAllApiParameters()
    {
        $allParameters = true;
        preg_replace_callback('!\{(\w+)\}!', function($matches) use(&$allParameters) {
            $name = $matches[1];
            if (empty($this->$name) || ctype_space($this->$name)) {
                $allParameters = false;
            }
            return true;
        }, $this->endpoint);
        return $allParameters;
    }

    /**
     * Perform a request to the API client.
     * TODO: Add error controls and more configurations
     *
     * @return mixed
     */
    protected function request($params = [])
    {
        $client = \App::make('ApiClient');
        $response = $client->request('GET', $this->getEndpoint(), $params);

        return $response;
    }

    public function hasApiFields() {
        return $this->apiError;
    }

    public function getApiField($field) {
        return $this->getApiFields[$field];
    }

    /**
     * Get API fields and its values stored at the object
     *
     * @return object
     */
    public function getApiFields() {
        return (object) array_reduce($this->apiFields, function($result, $field) {
            $result[$field] = $this->$field; return $result;
        }, array());
    }

}
