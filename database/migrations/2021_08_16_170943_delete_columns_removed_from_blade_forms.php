<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnsRemovedFromBladeForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_terms', function (Blueprint $table) {
            $table->dropColumn(['local_title', 'local_subtype']);
        });

        Schema::table('digital_publications', function (Blueprint $table) {
            $table->dropColumn(['short_description', 'publication_year']);
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blade_forms', function (Blueprint $table) {

        });
    }
}
