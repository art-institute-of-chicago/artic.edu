<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('custom_tours_items', function (Blueprint $table) {
            $table->text('artwork_count')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('custom_tours_items', function (Blueprint $table) {
            $table->dropColumn('artwork_count');
        });
    }
};
