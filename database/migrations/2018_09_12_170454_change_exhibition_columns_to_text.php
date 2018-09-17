<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeExhibitionColumnsToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->text('title')->change();
            $table->text('header_copy')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->string('title')->change();
            $table->string('header_copy')->change();
        });
    }
}
