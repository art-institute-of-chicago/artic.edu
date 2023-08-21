<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->text('description')->nullable();
            $table->integer('position')->unsigned()->nullable();
            $table->integer('digital_label_id')->unsigned();
            $table->foreign('digital_label_id')->references('id')->on('digital_labels')->onDelete('CASCADE');
        });

        Schema::create('experience_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'experience');
        });

        Schema::create('experience_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'experience');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_revisions');
        Schema::dropIfExists('experience_translations');
        Schema::dropIfExists('experience_slugs');
        Schema::dropIfExists('experiences');
    }
};
