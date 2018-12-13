<?php

namespace App\Models\Revisions;

use A17\Twill\Models\Revision;

class PrintedCatalogRevision extends Revision
{
    protected $table = "printed_catalog_revisions";

    protected $touches = ['printedCatalog'];

    public function printedCatalog()
    {
        return $this->belongsTo('App\Models\PrintedCatalog');
    }

}
