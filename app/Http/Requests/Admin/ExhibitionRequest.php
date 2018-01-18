<?php

namespace App\Http\Requests\Admin;

use A17\CmsToolkit\Http\Requests\Admin\Request;

class ExhibitionRequest extends Request
{
    public function rulesForCreate()
    {
        $rules = [
            'title' => 'required',
        ];

        return $rules;
    }

    public function rulesForUpdate()
    {
        $rules = [
            'title' => 'required',
        ];

        // if (!empty($this->input('end_date'))) {
        //     $rules['start_date'] = 'required|before:end_date';
        // } else {
        //     $rules['start_date'] = 'required';
        // }

        return $rules;
    }

}
