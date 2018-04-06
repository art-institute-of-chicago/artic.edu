<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMigratedNodeToPrintedCatalogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->unsignedInteger('migrated_node_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->dropColumn('migrated_node_id');
        });
    }
}
