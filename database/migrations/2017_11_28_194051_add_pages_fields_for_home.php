<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPagesFieldsForHome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            // Homepage
            $table->text('home_intro')->nullable();

            // Exhibition
            $table->text('exhibition_intro')->nullable();

            // Art and Ideas
            $table->text('art_intro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('home_intro');
            $table->dropColumn('exhibition_intro');
            $table->dropColumn('art_intro');
        });
    }
}
