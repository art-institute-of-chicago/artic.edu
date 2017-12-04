<?php

namespace App\Http\Requests\Admin;

use A17\CmsToolkit\Http\Requests\Admin\Request;

class EventRequest extends Request
{
    public function rules()
    {
        $rules = [
            'title' => 'required'
        ];

        if (!empty($this->input('price'))) {
            $rules['price'] = "required|regex:/^\d*(\.\d{1,2})?$/";
        }

        return $rules;
    }
}
