<?php

/**
 *
 * Extended Laravel Collection to include metadata.
 * This way we can just save information from search results
 * such as aggregations, pagination, suggestions, etc.
 *
 */

namespace App\Libraries\Api\Models;

class ApiCollection extends \Illuminate\Support\Collection {

    protected $metadata;

    public function getMetadata($name = null)
    {
        if ($this->metadata) {
            if ($name) {
                return $this->metadata->get($name);
            } else {
                return $this->metadata;
            }
        }
    }

    public function setMetadata($data)
    {
        if ($this->metadata) {
            if ($data instanceof \Illuminate\Support\Collection) {
                $this->metadata = $this->metadata->merge($data);
            } else {
                $this->metadata = $this->metadata->merge(collect($data));
            }
        } else {
            $this->metadata = collect($data);
        }

        return $this;
    }

}
