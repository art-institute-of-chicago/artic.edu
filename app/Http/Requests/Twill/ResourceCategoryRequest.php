<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class ResourceCategoryRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'name' => 'required'
        ];
    }
    public function rulesForUpdate()
    {
        return [
            'name' => 'required',
        ];
    }
}
