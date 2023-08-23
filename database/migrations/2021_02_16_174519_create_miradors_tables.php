<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('miradors', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title');
            $table->dateTime('date')->nullable();
            $table->string('object_id')->nullable();
            $table->string('upload_manifest_file')->nullable();
            $table->string('default_view')->default('single');
        });

        Schema::create('mirador_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'mirador');
        });

        Schema::create('mirador_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'mirador');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mirador_revisions');
        Schema::dropIfExists('mirador_slugs');
        Schema::dropIfExists('miradors');
    }
};
