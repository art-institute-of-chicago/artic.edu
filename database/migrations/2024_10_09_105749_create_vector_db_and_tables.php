<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    protected $connection;

    public function __construct()
    {
        $this->connection = 'vectors';
    }

    public function up(): void
    {
        // Ensure extension is enabled on the database
        DB::statement('CREATE EXTENSION IF NOT EXISTS vector');

        // Text embeddings table
        Schema::create('text_embeddings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('version'); // Version's are used to iterate on AI processor updates on regressions or improvements
            $table->string('model_name');
            $table->integer('model_id');
            $table->json('data'); // A general array used to store contextual/additional data that isn't an embedding
            // Add unique constraint
            $table->unique(['model_name', 'model_id']);
        });
        // Add vector column for text embeddings
        DB::statement('ALTER TABLE text_embeddings ADD COLUMN embedding vector(1536)');
        // Create hnsw index for text embeddings
        DB::statement('CREATE INDEX text_embeddings_idx ON text_embeddings USING hnsw (embedding vector_cosine_ops) WITH (m = 16, ef_construction = 64)');

        // Image embeddings table
        Schema::create('image_embeddings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('version'); // Version's are used to iterate on AI processor updates on regressions or improvements
            $table->string('model_name');
            $table->integer('model_id');
            $table->json('data'); // A general array used to store contextual/additional data that isn't an embedding
            // Add unique constraint
            $table->unique(['model_name', 'model_id']);
        });
        // Add vector column for image embeddings
        DB::statement('ALTER TABLE image_embeddings ADD COLUMN embedding vector(1024)');
        // Create hnsw index for image embeddings
        DB::statement('CREATE INDEX image_embeddings_idx ON image_embeddings USING hnsw (embedding vector_cosine_ops) WITH (m = 16, ef_construction = 64)');
    }

    public function down(): void
    {
        Schema::dropIfExists('text_embeddings');
        Schema::dropIfExists('image_embeddings');
    }
};
