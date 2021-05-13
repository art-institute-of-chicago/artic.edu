<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

use App\Libraries\SmartyPants;

use Illuminate\Support\Str;

use \DomDocument;
use \DOMXpath;

class BlockPresenter extends BasePresenter
{

    public function input($name)
    {
        if ($name == 'description') {
            $content = $this->entity->input($name);
            // Give IDs to H2s, H3s, and H4s
            $oldInternalErrors = libxml_use_internal_errors(true);

            $dom = new DomDocument();
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $xpath = new DOMXpath($dom);

            foreach($xpath->query('//h2') as $node) {
                $node->setAttribute('id', Str::slug($node->nodeValue));
            }

            foreach($xpath->query('//h3') as $node) {
                $node->setAttribute('id', Str::slug($node->nodeValue));
            }

            foreach($xpath->query('//h4') as $node) {
                $node->setAttribute('id', Str::slug($node->nodeValue));
            }

            $content = $dom->saveHTML($dom);

            libxml_clear_errors();
            libxml_use_internal_errors($oldInternalErrors);
            return SmartyPants::defaultTransform($content);
        }
        return SmartyPants::defaultTransform($this->entity->input($name));
    }

}
