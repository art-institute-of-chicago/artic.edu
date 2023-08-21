<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('opening_time')->nullable();
            $table->datetime('closing_time')->nullable();
            $table->integer('type');
            $table->integer('day_of_week');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hours');
    }
};
