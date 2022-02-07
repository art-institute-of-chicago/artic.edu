<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class ExhibitionPressRoomRevision extends Revision
{
    protected $table = 'exhibition_press_room_revisions';

    protected $touches = ['exhibitionPressRoom'];

    public function exhibitionPressRoom()
    {
        return $this->belongsTo('App\Models\ExhibitionPressRoom');
    }
}
