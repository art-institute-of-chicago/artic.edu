<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubheaderToLightboxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lightboxes', function (Blueprint $table) {
            $table->text('subheader')->nullable()->after('header');
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
            $table->dropColumn('subheader');
        });
    }
}
