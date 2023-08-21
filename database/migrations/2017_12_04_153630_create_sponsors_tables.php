<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('sponsors', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title');
            $table->text('copy');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
