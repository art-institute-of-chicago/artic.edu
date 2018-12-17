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
        $this->augmented      = true;
    }

    public function getAugmentedModel()
    {
        if (!$this->augmented)
            return;

        if ($this->augmentedModel)
            return $this->augmentedModel;

        // dd($this);

        return $this->augmentedModel =
            $this->augmentedModelClass::where('datahub_id', $this->id)->first();
    }

    public function hasAugmentedModel()
    {
        return $this->augmented;
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

