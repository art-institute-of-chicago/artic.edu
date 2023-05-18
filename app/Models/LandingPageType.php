<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPageType extends Model
{
    use HasFactory;

    public function getPageTypes()
    {
        return $this->pluck('page_type', 'id')->toArray();
    }
}
