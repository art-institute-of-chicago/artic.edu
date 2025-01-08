<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->dropColumn('header_title_display');
        });
    }

    public function down(): void
    {
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->string('header_title_display')->nullable();
        });
    }
};
