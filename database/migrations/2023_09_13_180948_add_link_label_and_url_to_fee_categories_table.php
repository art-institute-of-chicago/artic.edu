<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('fee_categories', function (Blueprint $table) {
            $table->string('link_label')->nullable();
            $table->string('link_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('fee_categories', function (Blueprint $table) {
            $table->dropColumn('link_label');
            $table->dropColumn('link_url');
        });
    }
};
