<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncreaseSizeOfExperienceImageCreditFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experience_images', function (Blueprint $table) {
            $table->text('artist')->change();
            $table->text('credit_date')->change();
            $table->text('dimensions')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('experience_images', function (Blueprint $table) {
            $table->string('artist')->change();
            $table->string('credit_date')->change();
            $table->string('dimensions')->change();
        });
    }
}
