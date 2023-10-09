<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTour extends Model
{
    protected $connection;

    public function __construct()
    {
        if (config('app.env') !== 'testing') {
            $this->connection = 'tours';
        }
    }

    protected $fillable = ['id', 'tour_json', 'timestamp'];
}
