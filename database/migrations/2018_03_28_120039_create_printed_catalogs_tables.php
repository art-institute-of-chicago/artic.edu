<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('printed_catalogs', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);
            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
        });

        Schema::create('printed_catalog_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'printed_catalog');
        });

        Schema::create('printed_catalog_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'printed_catalog');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('printed_catalog_revisions');
        Schema::dropIfExists('printed_catalog_slugs');
        Schema::dropIfExists('printed_catalogs');
    }
};
