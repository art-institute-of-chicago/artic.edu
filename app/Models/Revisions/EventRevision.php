<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class EventRevision extends Revision
{
    protected $table = 'event_revisions';

    protected $touches = ['event'];

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }
}
