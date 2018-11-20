<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class DigitalLabelRequest extends Request
{
    public function rulesForCreate()
    {
        $rules = [
            'datahub_id' => 'required',
        ];

        return $rules;
    }

    public function rulesForUpdate()
    {
        $rules = [
            'datahub_id' => 'required',
        ];

        // if (!empty($this->input('end_date'))) {
        //     $rules['start_date'] = 'required|before:end_date';
        // } else {
        //     $rules['start_date'] = 'required';
        // }

        return $rules;
    }

}
