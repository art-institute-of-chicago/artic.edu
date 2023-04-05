<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class DigitalPublicationRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'title' => 'required'
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'title' => 'required',
            'listing_description' => 'max:255',
            'hero_caption' => 'max:255',
            'bgcolor' => 'nullable|regex:/^#[0-9a-fA-F]{6}/'
        ];
    }
}
