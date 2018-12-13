<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class VideoRevision extends Revision
{
    protected $table = "video_revisions";

    protected $touches = ['video'];

    public function video()
    {
        return $this->belongsTo('App\Models\Video');
    }

}
