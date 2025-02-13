<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('categorized', function (Blueprint $table) {
            $table->increments('id');
            $table->string('categorizable_type');
            $table->integer('categorizable_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->index(['categorizable_type', 'categorizable_id']);
        });

        Schema::create('categories', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });

        Schema::create('category_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorized');
        Schema::dropIfExists('category_slugs');
        Schema::dropIfExists('categories');
    }
};
