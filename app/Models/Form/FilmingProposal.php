<?php

namespace App\Models\Form;

class FilmingProposal extends FormModel
{
    protected $casts = [
        'preferred_date_1' => 'date',
        'preferred_date_2' => 'date',
        'preferred_date_3' => 'date',
    ];
}
