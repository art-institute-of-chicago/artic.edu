<?php

namespace App\Http\Requests\Form;

class FilmingProposalRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'sometimes',
            'description' => 'required',
            'preferred_date_1' => 'required',
            'preferred_date_2' => 'sometimes',
            'preferred_date_3' => 'sometimes',
            'locations' => 'required',
            'required_time' => 'required',
            'crew_members' => 'required',
            'equipment_list' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateCaptcha($validator);
        });
    }
}
