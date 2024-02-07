<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CustomTour extends Model
{
    protected $connection;

    public function __construct()
    {
        $this->connection = 'tours';
    }

    protected $fillable = ['id', 'creator_email', 'marketing_opt_in', 'tour_json', 'timestamp', 'confirmation_sent'];

    protected $casts = ['tour_json' => 'array'];

    public function scopeNotSent(Builder $query)
    {
        $query->where('confirmation_sent', false);
        $query->whereNotNull('pdf_download_path');
        return $query;
    }
}
