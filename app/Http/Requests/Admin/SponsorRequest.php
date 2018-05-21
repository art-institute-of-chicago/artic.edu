<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class SponsorRequest extends Request
{
    public function rules()
    {
        $rules = [
            'title' => 'required',
            'copy' => 'required',
        ];

        return $rules;
    }
}
