<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('resource_categories', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });

        Schema::create('resource_category_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'resource_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resource_category_slugs');
        Schema::dropIfExists('resource_categories');
    }
};
