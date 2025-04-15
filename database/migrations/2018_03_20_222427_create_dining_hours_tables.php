<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('dining_hours', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('name')->nullable();
            $table->text('hours')->nullable();

            $table->integer('position')->unsigned()->nullable();

            $table->integer('page_id')->unsigned();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dining_hours');
    }
};
