<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTour extends Model
{
    use HasFactory;

    protected $connection = 'tours_db';

    protected $fillable = ['id', 'tour_json', 'timestamp'];
}
