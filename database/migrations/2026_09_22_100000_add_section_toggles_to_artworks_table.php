<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->boolean('toggle_autopublications')->default(false);
            $table->boolean('toggle_autoexhibitions')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn(['toggle_autopublications', 'toggle_autoexhibitions']);
        });
    }
};
