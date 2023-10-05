<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomTour extends Model
{
    protected $connection;

    public function __construct()
    {
        if (env('APP_ENV') !== 'testing') {
            $this->connection = 'tours';
        } else {
            $this->connection = env('DB_CONNECTION');
        }
    }

    protected $fillable = ['id', 'tour_json', 'timestamp'];
}
