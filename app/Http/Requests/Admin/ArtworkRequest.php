<?php

namespace App\Http\Requests\Admin;

use A17\CmsToolkit\Http\Requests\Admin\Request;

class ArtworkRequest extends Request
{
    public function rules()
    {
        $rules = [
            'title' => 'required',
            'datahub_id' => 'required'
        ];

        return $rules;
    }
}
