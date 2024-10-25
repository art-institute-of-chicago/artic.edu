<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\Vector;
use Pgvector\Laravel\Distance;
use Pgvector\Laravel\HasNeighbors;

class VectorEmbedding extends Model
{
    use HasNeighbors;

    protected $casts = ['embedding' => Vector::class];

    protected $connection;

    public function __construct() {

        $this->connection = 'vectors';

    }
}