<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $connection;

    public function __construct()
    {
        $this->connection = 'vectors';
    }

    public function up(): void
    {
        // Ensure extension is enabled on the database

        DB::statement(query: 'CREATE EXTENSION IF NOT EXISTS vector');

        // General embedding's table for vector search

        Schema::create(table: 'vector_embeddings', callback: function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
            $table->string(column: 'version'); // Version's are used to iterate on AI processor updates on regressions or improvements
            $table->string(column: 'type'); // Specifices the embedding type: Image, Text... Video? 😳
            $table->string(column: 'model_name');
            $table->integer(column: 'model_id');
            $table->json(column: 'data'); // A general array used to store contextual/additional data that isn't an embedding
            $table->vector('embedding', 1536);
        });

        // Create hnsw index for vector embeddings
        // https://en.wikipedia.org/wiki/Hierarchical_navigable_small_world

        DB::statement(query: 'CREATE INDEX ON vector_embeddings USING hnsw (embedding vector_cosine_ops) WITH (m = 16, ef_construction = 64)');

        // Applied weights table for search optimization

        Schema::create(table: 'vector_embedding_weights', callback: function (Blueprint $table): void {
            $table->id();
            $table->foreignId(column: 'vector_embedding_id')->constrained(table: 'vector_embeddings')->onDelete(action: 'cascade'); // Foreign key to embedding table
            $table->timestamps();
            $table->vector('query_embedding', 1536); // Store vectorized query for optimization
            $table->decimal(column: 'weight', total: 5, places: 2)->default(value: 1.0); // The weight applied to this embedding result (default is 1.0)
        });

        // The weights table will save normalized query embeddings and, upon user action, increment the weight based on the actual result

        // Example: "Articles of cats" is queried as an embedding frequently and returns 3 items.
        // The query_embedding is matched against the weight table and the embeddings of the 3 items is returned.
        // Users consistenly select the 2nd item based on that query so we weigh that higher.
        // Now when we query "Articles of cats" again users get a more practical result which corrects the order of expected results.
        // This makes the index self-correcting and adds a much more robust search. This is similar to practices of SEO.

        // NOTE: Weights should only be applied if the weight is above a variance threshold!
    }

    public function down(): void
    {
        Schema::dropIfExists(table: 'vector_embedding_weights');
        Schema::dropIfExists(table: 'vector_embeddings');
    }
};
