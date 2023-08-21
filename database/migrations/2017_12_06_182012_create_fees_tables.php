<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
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

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
