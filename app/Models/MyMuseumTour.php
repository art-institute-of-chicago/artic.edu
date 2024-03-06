<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyMuseumTour extends Model
{
    protected $connection;

    public function __construct()
    {
        $this->connection = 'tours';
    }

    protected $fillable = ['id', 'creator_email', 'marketing_opt_in', 'confirmation_sent', 'tour_json', 'timestamp'];

    protected $casts = ['tour_json' => 'array'];

    public function scopeNotSent($query)
    {
        $query->where('confirmation_sent', false);
        $query->whereNotNull('pdf_download_path');
        return $query;
    }
}
