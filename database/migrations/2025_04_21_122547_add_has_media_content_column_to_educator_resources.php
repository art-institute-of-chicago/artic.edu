<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('educator_resources', function (Blueprint $table) {
            $table->boolean('has_media_content')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('educator_resources', function (Blueprint $table) {
            $table->dropColumn('has_media_content');
        });
    }
};
