<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class ArtworkRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'title' => 'required',
            'artwork_website_url' => 'nullable|url'
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'title' => 'required',
            'artwork_website_url' => 'nullable|url'
        ];
    }
}
