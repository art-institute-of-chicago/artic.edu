<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class AIC3DModel extends Model
{
    protected $table = '3d_models';
    protected $fillable = [
        'model_url',
        'model_id',
        'camera_position',
        'camera_target',
        'annotation_list',
        'model_caption'
    ];
    protected $casts = [
        'camera_position' => 'array',
        'camera_target' => 'array',
        'annotation_list' => 'array',
    ];
}
