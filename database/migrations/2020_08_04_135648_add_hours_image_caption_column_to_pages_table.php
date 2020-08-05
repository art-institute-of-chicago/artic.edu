<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHoursImageCaptionColumnToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->text('visit_hour_image_caption')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->dropColumn('visit_hour_image_caption');
        });
    }
}
