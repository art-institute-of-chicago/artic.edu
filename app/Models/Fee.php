<?php

namespace App\Models;

class Fee extends AbstractModel
{
    protected $fillable = [
        'fee_age_id',
        'fee_category_id',
        'price',
    ];

    /**
     * Those fields get auto set to null if not submitted
     */
    public $nullable = [];

    /**
     * Those fields get auto set to false if not submitted
     */
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
