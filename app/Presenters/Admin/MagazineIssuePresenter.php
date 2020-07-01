<?php

namespace App\Presenters\Admin;

use App\Presenters\Admin\GenericPresenter;

class MagazineIssuePresenter extends GenericPresenter
{

    protected $linkIndex = 1;

    public function hero_text()
    {
        $p = "{<\s*a\s*(href=[^>]*)>([^<]*)</a>}i";

        return preg_replace_callback($p, [$this, 'hero_text_callback'], $this->entity->hero_text);
    }

    private function hero_text_callback($matches) {
        return '<a ' . $matches[1] . ' data-gtm-event="' . $matches[2] . '" data-gtm-event-action="' . $this->entity->title . '" data-gtm-event-category="header-text-link-' . $this->linkIndex++ . '">' . $matches[2] .'</a>';
    }

}
