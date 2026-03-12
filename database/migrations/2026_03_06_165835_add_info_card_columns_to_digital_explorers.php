<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_explorers', function (Blueprint $table) {
            $table->string('info_title')->nullable();
            $table->string('info_description')->nullable();
            $table->string('info_credits')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('digital_explorers', function (Blueprint $table) {
            $table->dropColumn('info_title');
            $table->dropColumn('info_description');
            $table->dropColumn('info_credits');
        });
    }
};
