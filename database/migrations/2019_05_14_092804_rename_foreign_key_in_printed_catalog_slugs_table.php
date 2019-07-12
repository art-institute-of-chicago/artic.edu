<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameForeignKeyInPrintedCatalogSlugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('printed_catalog_slugs', function (Blueprint $table) {
            if (Schema::hasColumn('printed_catalog_slugs', 'printed_publication_id')) {
                Schema::table('printed_catalog_slugs', function (Blueprint $table) {
                    $table->renameColumn('printed_publication_id', 'printed_catalog_id');
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('printed_catalog_slugs', function (Blueprint $table) {
            //
        });
    }
}
