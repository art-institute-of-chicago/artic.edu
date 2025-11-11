<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digital_explorers', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title');
            $table->string('type')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('short_description')->nullable();
            $table->string('listing_description')->nullable();
            $table->json('settings')->nullable();
        });

        Schema::create('digital_explorer_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'digital_explorer');
        });

        Schema::create('digital_explorer_annotations', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('position');
            $table->json('settings')->nullable();
            $table->foreignId('digital_explorer_id');
        });

        Schema::create('digital_explorer_lights', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('position');
            $table->json('settings')->nullable();
            $table->foreignId('digital_explorer_id');
        });

        Schema::create('digital_explorer_models', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('position');
            $table->json('settings')->nullable();
            $table->foreignId('digital_explorer_id');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('digital_explorer_digital_explorer_annotations');
        Schema::dropIfExists('digital_explorer_digital_explorer_lights');
        Schema::dropIfExists('digital_explorer_digital_explorer_models');
        Schema::dropIfExists('digital_explorer_annotations');
        Schema::dropIfExists('digital_explorer_lights');
        Schema::dropIfExists('digital_explorer_models');
        Schema::dropIfExists('digital_explorer_slugs');
        Schema::dropIfExists('digital_explorers');
    }
};
