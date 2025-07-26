<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\Vector;
// use ImageEmbeddingWeight;

class ImageEmbedding extends Model
{
    /**
     * The connection name for the model.
     */
    protected $connection = 'vectors';

    /**
     * The table associated with the model.
     */
    protected $table = 'image_embeddings';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'version',
        'model_name',
        'model_id',
        'data',
        'embedding'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'data' => 'array',
        'model_id' => 'integer',
        'embedding' => Vector::class,
    ];

    public function artwork()
    {
        return $this->morphTo('artwork', 'model_name', 'model_id');
    }

    /**
     * Get the weights for the image embedding.
     */
    // public function weights(): HasMany
    // {
    //     return $this->hasMany(ImageEmbeddingWeight::class);
    // }
}
