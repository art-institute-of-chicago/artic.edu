<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExhibitionHistoryPageFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            // Exhibition History
            $table->string('exhibition_history_sub_heading');
            $table->text('exhibition_history_intro_copy');
            $table->text('exhibition_history_popup_copy');
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
            $table->dropColumn('exhibition_history_sub_heading');
            $table->dropColumn('exhibition_history_intro_copy');
            $table->dropColumn('exhibition_history_popup_copy');
        });
    }
}
