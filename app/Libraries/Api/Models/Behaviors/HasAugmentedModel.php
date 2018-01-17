<?php

namespace App\Libraries\Api\Models\Behaviors;

trait HasAugmentedModel
{
    public $augmented = false;

    protected $augmentedModel;
    protected $augmentedModelClass;

    public function setAugmentedModel($model)
    {
        $this->augmentedModel = $model;
        $this->augmented      = true;
    }

    public function getAugmentedModel()
    {
        return $this->augmentedModel;
    }

    public function getAugmentedModelLoaded()
    {
        if ($this->augmentedModel)
            return $this->augmentedModel;

        return $this->augmentedModelClass::where('datahub_id', $this->id)->first();
    }

    public function hasAugmentedModel()
    {
        return empty($this->augmentedModel);
    }

    /**
     * Bypass missed methods to the augmented model if existent
     *
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this, $method)) {
            return $this->$method($parameters);
        }

        if ($this->hasAugmentedModel() && method_exists($this->getAugmentedModel(), $method)) {
            return $this->getAugmentedModel()->{$method}(...$parameters);
        }
    }
}

