<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->text('description')->nullable();
            $table->string('price', 200)->nullable();
            $table->string('url', 200)->nullable();
            $table->string('label', 200)->nullable();
            $table->integer('position')->unsigned()->nullable();

            $table->integer('exhibition_id')->unsigned();
            $table->foreign('exhibition_id')->references('id')->on('exhibitions')->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
