<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameStandardMediaTypeOnSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn('standard_media_type');
            $table->string('split_standard_media_type')->nullable();
            $table->string('fullwidthmedia_standard_media_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->string('standard_media_type')->nullable();
            $table->dropColumn('split_standard_media_type');
            $table->dropColumn('fullwidthmedia_standard_media_type');
        });
    }
}
