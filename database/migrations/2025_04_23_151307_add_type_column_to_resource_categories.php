<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('resource_categories', function (Blueprint $table) {
            $table->string('type')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('resource_categories', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
