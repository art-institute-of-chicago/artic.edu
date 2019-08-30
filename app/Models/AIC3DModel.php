<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class AIC3DModel extends Model
{
    protected $table = '3d_models';
    protected $fillable = [
        'model_id',
        'camera_position',
        'camera_target',
        'annotation_list'
    ];
    protected $casts = [
        'camera_position' => 'array',
        'camera_target' => 'array',
        'annotation_list' => 'array',
    ];

    public function setModelIdAttribute($value)
    {
        preg_match('/[a-z0-9]{10,}$/', $value, $matches);
        $this->attributes['model_id'] = $matches[0];
    }
}
