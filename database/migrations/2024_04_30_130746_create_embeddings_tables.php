<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('embeddings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->string('model_type');
            $table->string('embedding_type');
            $table->vector('embedding', 1536);
            $table->timestamps();
        });

        DB::statement('CREATE INDEX v_index ON embeddings USING ivfflat (embedding vector_l2_ops) WITH (lists = 100)');
    }

    public function down(): void
    {
        Schema::dropIfExists('embeddings');
    }
};
