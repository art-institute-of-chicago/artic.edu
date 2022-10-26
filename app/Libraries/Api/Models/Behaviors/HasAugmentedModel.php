<?php

namespace App\Libraries\Api\Models\Behaviors;

trait HasAugmentedModel
{
    protected $augmented = false;

    protected $augmentedModel;
    protected $augmentedModelClass;

    public function setAugmentedModel($model)
    {
        $this->augmentedModel = $model;
        $this->augmented = true;
    }

    public function getAugmentedModelClass()
    {
        return $this->augmentedModelClass;
    }

    public function getAugmentedModel()
    {
        if (!$this->augmented) {
            return;
        }

        if ($this->augmentedModel) {
            return $this->augmentedModel;
        }

        $this->augmentedModel = $this->augmentedModelClass::where('datahub_id', $this->id)->first();

        if (!$this->augmentedModel) {
            $this->augmented = false;
        }

        return $this->augmentedModel;
    }

    public function hasAugmentedModel()
    {
        return $this->augmented;
    }

    /**
     * Bypass missed methods to the augmented model if existent
     *
     */
    public function __call($method, $parameters): mixed
    {
        if (method_exists($this, $method)) {
            return $this->{$method}($parameters);
        }

        if ($this->hasAugmentedModel() && $this->getAugmentedModel() && method_exists($this->getAugmentedModel(), $method)) {
            return $this->getAugmentedModel()->{$method}(...$parameters);
        }

        return null;
    }
}
