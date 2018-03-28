<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDigitalCatalogsTables extends Migration
{
    public function up()
    {
        Schema::create('digital_catalogs', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);
            // add some fields
            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
        });

        // remove this if you're not going to use slugs
        Schema::create('digital_catalog_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'digital_catalog');
        });

        // remove this if you're not going to use revisions
        Schema::create('digital_catalog_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'digital_catalog');
        });
    }

    public function down()
    {
        Schema::dropIfExists('digital_catalog_revisions');
        Schema::dropIfExists('digital_catalog_slugs');
        Schema::dropIfExists('digital_catalogs');
    }
}
