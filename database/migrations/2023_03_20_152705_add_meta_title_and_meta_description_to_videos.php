<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('search_tags')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('search_tags');
        });
    }
};
