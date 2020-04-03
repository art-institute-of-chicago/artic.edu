<?php

namespace App\Http\Controllers\Admin;

class PreviewController
{

    public function show($hash)
    {
        dd(decrypt($hash));
    }

}
