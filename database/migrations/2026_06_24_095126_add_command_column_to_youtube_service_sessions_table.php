<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('youtube_service_sessions', function (Blueprint $table) {
            $table->string('command')->nullable()->after('errored_at');
        });
    }

    public function down(): void
    {
        Schema::table('youtube_service_sessions', function (Blueprint $table) {
            $table->dropColumn('command');
        });
    }
};
