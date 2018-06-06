<?php

namespace App\Models;

use A17\Twill\Models\Model;

class Fee extends Model
{
    protected $fillable = [
        'fee_age_id',
        'fee_category_id',
        'price',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

    public function fee_age()
    {
        return $this->belongsTo('App\Models\FeeAge');
    }

    public function fee_category()
    {
        return $this->belongsTo('App\Models\FeeCategory');
    }
}
