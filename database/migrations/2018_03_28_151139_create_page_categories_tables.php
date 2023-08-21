<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('page_categories', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });

        Schema::create('page_category_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'page_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_category_slugs');
        Schema::dropIfExists('page_categories');
    }
};
