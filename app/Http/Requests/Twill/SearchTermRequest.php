<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class SearchTermRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'name' => 'required',
            'direct_url' => 'required'
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'name' => 'required',
            'direct_url' => 'required'
        ];
    }
}
