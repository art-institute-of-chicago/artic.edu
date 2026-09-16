<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('digital_explorers', function (Blueprint $table) {
            $table->text('info_description')->change();
        });
    }

    public function down(): void
    {
        Schema::table('digital_explorers', function (Blueprint $table) {
            $table->string('info_description')->change();
        });
    }
};
