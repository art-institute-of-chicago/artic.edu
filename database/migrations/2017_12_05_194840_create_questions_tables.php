<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->integer('position')->unsigned()->nullable();

            $table->text('question');
            $table->text('answer');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
