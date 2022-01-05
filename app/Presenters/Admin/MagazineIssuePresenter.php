<?php

namespace App\Presenters\Admin;

class MagazineIssuePresenter extends GenericPresenter
{
    protected $linkIndex = 1;

    public function hero_text()
    {
        $p = "{<\s*a\s*(.*?)>(.*?)</a>}i";

        return preg_replace_callback($p, [$this, 'hero_text_callback'], $this->entity->hero_text);
    }

    private function hero_text_callback($matches)
    {
        $gtmEvent = $matches[2]; // Link text
        preg_match("{href=\"([a-zA-Z0-9\/\:\?\#\-\_\.]+)\"}i", $matches[1], $urlMatches);
        if ($urlMatches) {
            $url = parse_url($urlMatches[1], PHP_URL_PATH);
            $gtmEvent = substr($url, strrpos($url, '/') + 1); // Last part of path
        }

        return '<a ' . $matches[1] . ' data-gtm-event="' . $gtmEvent . '" data-gtm-event-category="header-text-link-' . $this->linkIndex++ . '">' . $matches[2] . '</a>';
    }
}
