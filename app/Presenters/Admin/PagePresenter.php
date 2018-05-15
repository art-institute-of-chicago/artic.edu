<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;

class PagePresenter extends BasePresenter
{

    public function introBlocks()
    {
        return [
            [
                "type"    => 'text',
                "content" => '<p>' . $this->entity->exhibition_history_intro_copy . '</p>'
            ]
        ];
    }

    public function exhibitionHistoryMedia()
    {
        return [
            'type'  => 'image',
            'size'  => 's',
            'media' => $this->entity->imageFront('exhibition_history_intro'),
            'hideCaption' => true
        ];
    }

}
