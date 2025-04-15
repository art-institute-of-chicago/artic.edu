<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class BuildingClosureRequest extends Request
{
    public function rules()
    {
        $rules = ['type' => 'required'];

        if (!empty($this->input('date_end'))) {
            $rules['date_start'] = 'required|before_or_equal:date_end';
        } else {
            $rules['date_start'] = 'required';
        }

        $rules['date_end'] = 'required';

        return $rules;
    }

    public function messages()
    {
        return [
            'date_start.before' => 'Start date must happen before ending date.',
        ];
    }
}
