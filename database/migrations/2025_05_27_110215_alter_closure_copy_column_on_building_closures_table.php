<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('building_closures', function (Blueprint $table) {
            $table->text('closure_copy')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('building_closures', function (Blueprint $table) {
            $table->string('closure_copy', length: 191)->nullable()->change();
        });
    }
};
