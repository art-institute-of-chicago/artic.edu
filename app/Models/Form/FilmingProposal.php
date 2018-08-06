<?php

namespace App\Models\Form;

use Carbon\Carbon;

class FilmingProposal extends FormModel
{
    protected $dates = ['preferred_date_1', 'preferred_date_2', 'preferred_date_3'];
}
