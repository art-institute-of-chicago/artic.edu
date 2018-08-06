<?php

namespace App\Models\Form;

use Carbon\Carbon;

class RyersonClassVisit extends FormModel
{
    protected $dates = array(
        'preferred_date_1',
        'preferred_date_2',
        'preferred_date_3',
        'instructor_materials_review_date_1',
        'instructor_materials_review_date_2',
        'instructor_materials_review_date_3',
    );
}
