<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeDisplayToDigitalPublicationSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('digital_publication_sections', function (Blueprint $table) {
            $table->string('type_display')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('digital_publication_sections', function (Blueprint $table) {
            $table->dropColumn('type_display');
        });
    }
}
