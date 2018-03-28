<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageCategoriesTables extends Migration
{
    public function up()
    {
        Schema::create('page_categories', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });

        Schema::create('page_category_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'page_category');
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_category_slugs');
        Schema::dropIfExists('page_categories');
    }
}
