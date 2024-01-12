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


    public function fee_age() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->belongsTo('App\Models\FeeAge');
    }

    public function fee_category() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->belongsTo('App\Models\FeeCategory');
    }
}
