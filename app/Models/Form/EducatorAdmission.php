<?php

namespace App\Models\Form;

class EducatorAdmission extends FormModel
{
    protected $casts = [
        'visit_date' => 'date'
    ];
}
