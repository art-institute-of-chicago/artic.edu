<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTour extends Model
{
    protected $connection = 'tours';

    protected $fillable = ['id', 'tour_json', 'timestamp'];
}
