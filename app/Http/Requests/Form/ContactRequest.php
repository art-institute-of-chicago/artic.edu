<?php

namespace App\Http\Requests\Form;

use A17\Twill\Http\Requests\Admin\Request;

class ContactRequest extends Request
{
    public function rules()
    {
        return [
            'prefix' => 'sometimes',
            'first_name' => 'required',
            'middle_initial' => 'sometimes',
            'last_name' => 'required',
            'phone_number' => 'required',
            'address_1' => 'required',
            'address_2' => 'sometimes',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'country' => 'required',
            'visit_date' => 'required|date',
            'comments' => 'sometimes',
            'days_class_meets' => 'required',
            'type_of_visit' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'address_1.required' => 'Street address is required',
            'days_class_meets.required' => 'Days the class meets is required',
            'type_of_visit.required' => 'Type of visit is required',
        ];
    }
}
