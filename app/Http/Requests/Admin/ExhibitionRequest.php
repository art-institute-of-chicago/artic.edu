<?php

namespace App\Http\Requests\Admin;

use A17\CmsToolkit\Http\Requests\Admin\Request;

class ExhibitionRequest extends Request
{
    public function rules()
    {
        $rules = [
            'title' => 'required'
        ];

        if (!empty($this->input('end_date'))) {
            $rules['start_date'] = 'date_format:m/d/Y H:i|before:end_date';
        } else {
            $rules['start_date'] = 'required|date_format:m/d/Y H:i';
        }

        $rules['end_date'] = 'date_format:m/d/Y H:i';

        return $rules;
    }
}
