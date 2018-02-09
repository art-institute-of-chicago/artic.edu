<?php

namespace App\Presenters;
use Illuminate\Contracts\Routing\UrlRoutable;

class StaticObjectPresenter implements UrlRoutable
{
    protected $entity; // This is to store the original array instance

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function __call($name, $args)
    {
        if ( isset($this->entity[$name])) {
            return call_user_func_array($this->entity[$name], ['this' => $this] + $args);
        }
    }

    // Call the function if that exists, or return the property on the original model
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->entity[$property] ?? '';
    }

    public function push($index, $value)
    {
        $this->entity[$index] = $value;
    }

    // Implement UrlRoutable functions

    public function getRouteKey() {
        return $this->entity['id'];
    }

    public function getRouteKeyName() {
        return 'id';
    }

    public function resolveRouteBinding($value) {
        return $this->entity;
    }
}
