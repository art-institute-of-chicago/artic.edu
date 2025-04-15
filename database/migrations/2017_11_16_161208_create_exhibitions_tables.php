<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('exhibitions', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('title');
            $table->string('short_copy')->nullable();
            $table->string('header_copy')->nullable();

            // Use a json field to store block editor fields
            $table->json('content')->nullable();

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
        });

        Schema::create('exhibition_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'exhibition');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exhibition_slugs');
        Schema::dropIfExists('exhibitions');
    }
};
