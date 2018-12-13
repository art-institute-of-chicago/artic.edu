<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class DigitalCatalogRevision extends Revision
{
    protected $table = "digital_catalog_revisions";

    protected $touches = ['digitalCatalog'];

    public function digitalCatalog()
    {
        return $this->belongsTo('App\Models\DigitalCatalog');
    }

}
