<?php

namespace App\Http\Requests\Form;

class EducatorAdmissionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'visit_date' => 'required',
            'school_location' => 'required',

            'type_of_educator' => 'required',
            'grades_taught' => 'required',
            'subjects_taught' => 'required',

        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateCaptcha($validator);
        });
    }

}
