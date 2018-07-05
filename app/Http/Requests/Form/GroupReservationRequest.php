<?php

namespace App\Http\Requests\Form;

use A17\Twill\Http\Requests\Admin\Request;

class GroupReservationRequest extends Request
{
    public function rules()
    {
        return [
            'group_name' => 'sometimes',
            'contact_name' => 'required',
            'email' => 'required',
            'phone_number' => 'sometimes',
            'fax_number' => 'sometimes',
            'address_1' => 'sometimes',
            'address_2' => 'sometimes',
            'city' => 'sometimes',
            'state' => 'sometimes',
            'zipcode' => 'sometimes',
            'country' => 'sometimes',

            'visit_date' => 'sometimes',
            'visit_time' => 'sometimes',

            'no_of_adults' => 'sometimes',
            'no_of_students' => 'sometimes',
            'no_of_seniors' => 'sometimes',

            'dining_option' => 'sometimes',
            'no_of_audio_tours' => 'sometimes',
            'topic' => 'sometimes',
            'needs' => 'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'contact_name.required' => 'Contact name is required',
            'email.required' => 'Email is required',
        ];
    }
}
