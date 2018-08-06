<?php

namespace App\Http\Requests\Form;

class RyersonClassVisitRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'sometimes',
            'affiliation' => 'required',
            'non_saic_institution' => 'sometimes',
            'department' => 'required',
            'course_title' => 'required',
            'course_level' => 'required',
            'days_class_meets' => 'required',
            'no_of_sessions' => 'required',
            'multiple_sessions_description' => 'sometimes',
            'preferred_date_1' => 'required',
            'preferred_date_2' => 'sometimes',
            'preferred_date_3' => 'sometimes',
            'preferred_time' => 'required',
            'alt_times' => 'sometimes',
            'no_of_students' => 'required',
            'type_of_visit' => 'required',
            'session_objective' => 'required',
            'collections_related_assignment_description' => 'required',
            'collection_materials_requested_for_visit' => 'required',
            'instructor_materials_review_date_1' => 'required',
            'instructor_materials_review_time_1' => 'required',
            'instructor_materials_review_date_2' => 'sometimes',
            'instructor_materials_review_time_2' => 'sometimes',
            'instructor_materials_review_date_3' => 'sometimes',
            'instructor_materials_review_time_3' => 'sometimes',
            'research_shelf_required' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validateCaptcha($validator);
        });
    }

    public function messages()
    {
        return [
            'preferred_date_1.required' => 'A preferred date is required',
            'no_of_students.required' => 'The number of students field is required',
            'instructor_materials_review_date_1.required' => 'A potential date for instructor materials review is required',
            'instructor_materials_review_time_1.required' => 'A potential time for instructor materials review is required',
        ];
    }

}
