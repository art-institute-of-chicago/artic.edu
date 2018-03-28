<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCatalogCategoriesTables extends Migration
{
    public function up()
    {
        Schema::create('catalog_categories', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });

        Schema::create('catalog_category_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'catalog_category');
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalog_category_slugs');
        Schema::dropIfExists('catalog_categories');
    }
}
