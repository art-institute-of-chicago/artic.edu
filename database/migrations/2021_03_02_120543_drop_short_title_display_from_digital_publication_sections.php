<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropShortTitleDisplayFromDigitalPublicationSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('digital_publication_sections', function (Blueprint $table) {
            $table->dropColumn('short_title_display');
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
            $table->text('short_title_display')->nullable();
        });
    }
}
