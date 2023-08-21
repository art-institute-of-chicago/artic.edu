<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->integer('label');
            $table->string('position');
            $table->string('link');
            $table->integer('page_id');
            $table->foreignId('landing_page_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
