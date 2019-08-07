<?php

namespace App\Http\Requests\Form;

class GroupReservationRequest extends FormRequest
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

            'no_of_audio_tours' => 'sometimes',
            'topic' => 'sometimes',
            'needs' => 'sometimes',
            'additional_info' => 'sometimes',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateCaptcha($validator);
        });
    }
}
