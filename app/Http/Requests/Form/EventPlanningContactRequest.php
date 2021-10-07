<?php

namespace App\Http\Requests\Form;

class EventPlanningContactRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'address_1' => 'sometimes',
            'address_2' => 'sometimes',
            'city' => 'sometimes',
            'state' => 'sometimes',
            'zipcode' => 'sometimes',
            'country' => 'sometimes',
            'company' => 'sometimes',
            'email' => 'required',
            'phone_number' => 'required',
            'preferred_contact' => 'sometimes',
            'how_did_you_hear' => 'sometimes',
            'how_did_you_hear_other' => 'sometimes',
            'are_you_currently_planning' => 'sometimes',
            'type_of_event' => 'sometimes',
            'type_of_event_other' => 'sometimes',
            'no_of_expected_guests' => 'sometimes',
            'possible_date_1' => 'sometimes',
            'possible_date_2' => 'sometimes',
            'possible_date_3' => 'sometimes',
            'other_info' => 'sometimes',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateCaptcha($validator);
        });
    }
}
