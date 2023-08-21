<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('closures', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->date('date_start');
            $table->date('date_end');
            $table->string('closure_copy')->nullable();
            $table->integer('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('closures');
    }
};
