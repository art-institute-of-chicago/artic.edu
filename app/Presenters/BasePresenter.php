<?php

namespace App\Presenters;

use App\Libraries\SmartyPants;
use Illuminate\Support\Str;
use DomDocument;

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
            if (method_exists($this->entity, 'translatedAttribute') && $this->entity->translatedAttribute($property)) {
                $translatedField = $this->entity->translatedAttribute($property)->toArray();
                $return = $this->getLocalizedField($translatedField);

                $oldInternalErrors = libxml_use_internal_errors(true);
                $dom = new DomDocument();
                $dom->loadHTML('<?xml encoding="utf-8" ?>' . $return, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $content = $dom->saveHTML($dom);
                $prefix = '<?xml encoding="utf-8" ?>';
                if (Str::startsWith($content, $prefix)) {
                    $content = Str::substr($content, Str::length($prefix));
                }

                libxml_clear_errors();
                libxml_use_internal_errors($oldInternalErrors);

                return $return ? SmartyPants::defaultTransform($return) : null;
            } else {
                return $return ? SmartyPants::defaultTransform($return) : null;
            }
        }

        return $return;
    }

    /**
     * WEB-912, WEB-1644: For compatibility with BlockPresenter, media.blade.php, and videoUrl
     */
    public function input($name)
    {
        return $this->getLocalizedField($this->{$name});
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
        return $this->entity->blocks()->where('type', '=', 'paragraph')->pluck('content')->implode('paragraph.en', '');
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

    public function headerType()
    {
        return null;
    }

    public function getLocalizedField($name = null)
    {
        $field = $name;

        // If it's not an array return
        if (!is_array($field)) {
            return $field;
        }

        if (empty($field)) {
            return '';
        }

        $requestLocale = app('request')->input('locale');

        if ($requestLocale && isset($field[$requestLocale]) && !empty($field[$requestLocale])) {
            return $field[$requestLocale];
        }

        $currentLocale = app()->getLocale();
        if (isset($field[$currentLocale]) && !empty($field[$currentLocale])) {
            return $field[$currentLocale];
        }

        $fallbackLocale = config('app.fallback_locale', 'en');
        if (isset($field[$fallbackLocale]) && !empty($field[$fallbackLocale])) {
            return $field[$fallbackLocale];
        }

        // Last resort return any locale we have
        return collect($field)->filter()->first() ?? '';
    }
}
