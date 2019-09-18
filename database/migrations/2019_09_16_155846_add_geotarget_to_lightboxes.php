<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeotargetToLightboxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lightboxes', function (Blueprint $table) {
            $table->integer('geotarget')->nullable()->index()->after('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lightboxes', function (Blueprint $table) {
            $table->dropColumn('geotarget');
        });
    }
}
