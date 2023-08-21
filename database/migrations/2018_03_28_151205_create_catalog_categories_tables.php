<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('catalog_categories', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });

        Schema::create('catalog_category_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'catalog_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_category_slugs');
        Schema::dropIfExists('catalog_categories');
    }
};
