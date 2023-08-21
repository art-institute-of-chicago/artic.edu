<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_ages', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);

            $table->integer('position')->unsigned()->nullable();
            $table->string('title');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_ages');
    }
};
