<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = "form_contacts";
    protected $dates = ['visit_date'];
}
