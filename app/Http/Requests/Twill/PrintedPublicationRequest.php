<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class PrintedPublicationRequest extends Request
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
            'short_description' => 'max:255'
        ];
    }
}
