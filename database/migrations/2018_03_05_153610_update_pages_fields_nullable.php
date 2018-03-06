<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePagesFieldsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('exhibition_history_sub_heading');
            $table->dropColumn('exhibition_history_intro_copy');
            $table->dropColumn('exhibition_history_popup_copy');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('exhibition_history_sub_heading')->nullable();
            $table->text('exhibition_history_intro_copy')->nullable();
            $table->text('exhibition_history_popup_copy')->nullable();
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

        Schema::table('pages', function (Blueprint $table) {
            // Exhibition History
            $table->string('exhibition_history_sub_heading');
            $table->text('exhibition_history_intro_copy');
            $table->text('exhibition_history_popup_copy');
        });
    }
}
