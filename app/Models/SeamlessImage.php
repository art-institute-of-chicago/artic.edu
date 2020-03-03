<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeamlessImage extends Model
{
    protected $fillable = ['file_name', 'zip_file_id', 'frame'];
}
