<?php

namespace App\Http\Requests\Form;

use A17\Twill\Http\Requests\Admin\Request;

class EducatorAdmissionRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'visit_date' => 'required',
            'phone_number' => 'required',
            'address_1' => 'required',
            'address_2' => 'sometimes',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',

            'school_name' => 'required',
            'school_city' => 'required',
            'school_state' => 'required',
            'school_location' => 'required',

            'type_of_educator' => 'required',
            'grades_taught' => 'required',
            'subjects_taught' => 'required',

        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
