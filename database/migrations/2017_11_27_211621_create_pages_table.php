<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->integer('position')->unsigned()->index();
            $table->string('title');

            // Page type
            $table->integer('type')->unsigned();
            $table->unique('type');
        });

        Schema::create('page_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'page');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('page_slugs');
        Schema::dropIfExists('pages');
    }
};
