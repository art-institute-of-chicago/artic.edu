<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorHoursTableAgain extends Migration
{
    public function up()
    {
        Schema::table('hours', function (Blueprint $table) {
            $table->boolean('monday_is_closed')->nullable();
            $table->string('monday_member_open')->nullable();
            $table->string('monday_member_close')->nullable();
            $table->string('monday_public_open')->nullable();
            $table->string('monday_public_close')->nullable();

            $table->boolean('tuesday_is_closed')->nullable();
            $table->string('tuesday_member_open')->nullable();
            $table->string('tuesday_member_close')->nullable();
            $table->string('tuesday_public_open')->nullable();
            $table->string('tuesday_public_close')->nullable();

            $table->boolean('wednesday_is_closed')->nullable();
            $table->string('wednesday_member_open')->nullable();
            $table->string('wednesday_member_close')->nullable();
            $table->string('wednesday_public_open')->nullable();
            $table->string('wednesday_public_close')->nullable();

            $table->boolean('thursday_is_closed')->nullable();
            $table->string('thursday_member_open')->nullable();
            $table->string('thursday_member_close')->nullable();
            $table->string('thursday_public_open')->nullable();
            $table->string('thursday_public_close')->nullable();

            $table->boolean('friday_is_closed')->nullable();
            $table->string('friday_member_open')->nullable();
            $table->string('friday_member_close')->nullable();
            $table->string('friday_public_open')->nullable();
            $table->string('friday_public_close')->nullable();

            $table->boolean('saturday_is_closed')->nullable();
            $table->string('saturday_member_open')->nullable();
            $table->string('saturday_member_close')->nullable();
            $table->string('saturday_public_open')->nullable();
            $table->string('saturday_public_close')->nullable();

            $table->boolean('sunday_is_closed')->nullable();
            $table->string('sunday_member_open')->nullable();
            $table->string('sunday_member_close')->nullable();
            $table->string('sunday_public_open')->nullable();
            $table->string('sunday_public_close')->nullable();

            $table->text('additional_text')->nullable();
            $table->text('summary')->nullable();
        });
    }

    public function down()
    {
        Schema::table('hours', function (Blueprint $table) {
            $table->dropColumn('monday_is_closed')->nullable();
            $table->dropColumn('monday_member_open')->nullable();
            $table->dropColumn('monday_member_close')->nullable();
            $table->dropColumn('monday_public_open')->nullable();
            $table->dropColumn('monday_public_close')->nullable();

            $table->dropColumn('tuesday_is_closed')->nullable();
            $table->dropColumn('tuesday_member_open')->nullable();
            $table->dropColumn('tuesday_member_close')->nullable();
            $table->dropColumn('tuesday_public_open')->nullable();
            $table->dropColumn('tuesday_public_close')->nullable();

            $table->dropColumn('wednesday_is_closed')->nullable();
            $table->dropColumn('wednesday_member_open')->nullable();
            $table->dropColumn('wednesday_member_close')->nullable();
            $table->dropColumn('wednesday_public_open')->nullable();
            $table->dropColumn('wednesday_public_close')->nullable();

            $table->dropColumn('thursday_is_closed')->nullable();
            $table->dropColumn('thursday_member_open')->nullable();
            $table->dropColumn('thursday_member_close')->nullable();
            $table->dropColumn('thursday_public_open')->nullable();
            $table->dropColumn('thursday_public_close')->nullable();

            $table->dropColumn('friday_is_closed')->nullable();
            $table->dropColumn('friday_member_open')->nullable();
            $table->dropColumn('friday_member_close')->nullable();
            $table->dropColumn('friday_public_open')->nullable();
            $table->dropColumn('friday_public_close')->nullable();

            $table->dropColumn('saturday_is_closed')->nullable();
            $table->dropColumn('saturday_member_open')->nullable();
            $table->dropColumn('saturday_member_close')->nullable();
            $table->dropColumn('saturday_public_open')->nullable();
            $table->dropColumn('saturday_public_close')->nullable();

            $table->dropColumn('sunday_is_closed')->nullable();
            $table->dropColumn('sunday_member_open')->nullable();
            $table->dropColumn('sunday_member_close')->nullable();
            $table->dropColumn('sunday_public_open')->nullable();
            $table->dropColumn('sunday_public_close')->nullable();

            $table->dropColumn('additional_text')->nullable();
            $table->dropColumn('summary')->nullable();
        });
    }
}
