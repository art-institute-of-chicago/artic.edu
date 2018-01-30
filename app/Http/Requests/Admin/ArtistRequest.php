<?php

namespace App\Http\Requests\Admin;

use A17\CmsToolkit\Http\Requests\Admin\Request;

class ArtistRequest extends Request
{
    public function rules()
    {
        $rules = [
            'datahub_id' => 'required'
        ];

        return $rules;
    }
}
