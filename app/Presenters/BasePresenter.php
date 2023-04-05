<?php

namespace App\Presenters;

use App\Libraries\SmartyPants;

abstract class BasePresenter
{
    /**
     * This is to store the original model instance
     */
    protected $entity;

    public function __construct(&$entity)
    {
        $this->entity = &$entity;
    }

    public function __get($property): mixed
    {
        $return = $this->entity->{$property};

        if (method_exists($this, $property)) {
            $return = $this->{$property}();
        }

        if (is_string($return)) {
            return $return ? SmartyPants::defaultTransform($return) : null;
        }

        return $return;
    }

    /**
     * WEB-912, WEB-1644: For compatibility with BlockPresenter, media.blade.php, and videoUrl
     */
    public function input($name)
    {
        return $this->{$name};
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

    public function presentPublishStartDate()
    {
        if ($this->entity->publish_start_date) {
            if (!empty($this->entity->publish_start_date)) {
                return $this->entity->publish_start_date->format('m d Y');
            }
        }

        return 'No';
    }

    protected function addCssClass($html, $class)
    {
        $oldInternalErrors = libxml_use_internal_errors(true);

        $dom = new \DomDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new \DOMXpath($dom);
        $nodes = $xpath->query('//ol | //ul | //p');

        foreach ($nodes as $node) {
            $node->setAttribute('class', $class);
        }

        $result = str_replace('<?xml encoding="utf-8" ?>', '', $dom->saveHTML($dom));

        libxml_clear_errors();
        libxml_use_internal_errors($oldInternalErrors);

        return $result;
    }
}
