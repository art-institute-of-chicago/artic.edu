<?php

namespace App\Presenters;

use Carbon\Carbon;

abstract class BasePresenter
{

    protected $entity; // This is to store the original model instance

    public function __construct(&$entity)
    {
        $this->entity = &$entity;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->entity->{$property};
    }

    public function contrastHeader()
    {
        switch ($this->headerType()) {
            case 'feature':
            case 'super-hero':
            case 'hero':
                return true;
                break;

            default:
                return false;
        }
    }

    public function borderlessHeader()
    {
        switch ($this->headerType()) {
            case 'gallery':
                return true;
                break;

            default:
                return false;
        }
    }

    public function copy()
    {
        return $this->entity->blocks()->where('type', '=', 'paragraph')->pluck('content')->implode('paragraph', '');
    }

    public function presentPublishStartDate() {
        if ($this->entity->publish_start_date) {
            if (!empty($this->entity->publish_start_date)) {
                return $this->entity->publish_start_date->format('m d Y');
            }
        }

        return "No";
    }

}
