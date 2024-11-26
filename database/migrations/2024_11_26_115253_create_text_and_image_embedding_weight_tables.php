<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('text_embedding_weights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('text_embedding_id')
                ->constrained('text_embeddings')
                ->onDelete('cascade');
            $table->timestamps();
            $table->vector('query_embedding', 1536);
            $table->decimal('weight', 5, 2)->default(1.0);
            
            $table->index('weight');
        });

        Schema::create('image_embedding_weights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('image_embedding_id')
                ->constrained('image_embeddings')
                ->onDelete('cascade');
            $table->timestamps();
            $table->vector('query_embedding', 1024);
            $table->decimal('weight', 5, 2)->default(1.0);
            
            $table->index('weight');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('text_embedding_weights');
        Schema::dropIfExists('image_embedding_weights');
    }
};
