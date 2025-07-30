<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class EmbeddingUpdate extends Model
{
    /**
     * The connection name for the model.
     */
    protected $connection = 'vectors';

    /**
     * The table associated with the model.
     */
    protected $table = 'embedding_updates';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'created_at',
        'embedding_type',
        'model_name',
        'model_id',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'embedding_type' => 'string',
        'model_name' => 'string',
        'model_id' => 'integer',
    ];

    public function artwork()
    {
        return $this->morphTo('artwork', 'model_name', 'model_id');
    }
}
