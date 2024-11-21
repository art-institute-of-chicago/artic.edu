<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class ArtworkRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'artwork_website_url' => 'nullable|url'
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'artwork_website_url' => 'nullable|url'
        ];
    }
}
