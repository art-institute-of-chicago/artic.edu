<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\Vector;

// TODO: Utilize Embedding weights
// use TextEmbeddingWeight;

class TextEmbedding extends Model
{
    /**
     * The connection name for the model.
     */
    protected $connection = 'vectors';

    /**
     * The table associated with the model.
     */
    protected $table = 'text_embeddings';

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

    // TODO: Create Embedding weight models

    /**
     * Get the weights for the text embedding.
     */
    // public function weights(): HasMany
    // {
    //     return $this->hasMany(TextEmbeddingWeight::class);
    // }
}
