<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('label')->change();
            $table->integer('page_id')->nullable()->change();
            $table->foreignId('landing_page_id')->nullable()->change();
        });
    }

    public function down(): void
    {
    }
};
