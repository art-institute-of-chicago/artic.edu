<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResourceCategoriesTables extends Migration
{
    public function up()
    {
        Schema::create('resource_categories', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });

        Schema::create('resource_category_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'resource_category');
        });
    }

    public function down()
    {
        Schema::dropIfExists('resource_category_slugs');
        Schema::dropIfExists('resource_categories');
    }
}
