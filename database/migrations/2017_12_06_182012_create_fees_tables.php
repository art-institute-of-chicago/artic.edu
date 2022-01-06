<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeesTables extends Migration
{
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);

            $table->integer('fee_age_id')->unsigned();
            $table->foreign('fee_age_id')->references('id')->on('fee_ages')->onDelete('CASCADE');
            $table->integer('fee_category_id')->unsigned();
            $table->foreign('fee_category_id')->references('id')->on('fee_categories')->onDelete('CASCADE');
            $table->double('price', 8, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fees');
    }
}
