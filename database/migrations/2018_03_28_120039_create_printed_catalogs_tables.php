<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrintedCatalogsTables extends Migration
{
    public function up()
    {
        Schema::create('printed_catalogs', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);
            // add some fields
            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
        });

        // remove this if you're not going to use slugs
        Schema::create('printed_catalog_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'printed_catalog');
        });

        // remove this if you're not going to use revisions
        Schema::create('printed_catalog_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'printed_catalog');
        });
    }

    public function down()
    {
        Schema::dropIfExists('printed_catalog_revisions');
        Schema::dropIfExists('printed_catalog_slugs');
        Schema::dropIfExists('printed_catalogs');
    }
}
