<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->boolean('suppress_listing')->default(false);
            $table->boolean('hide_title')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->dropColumn('suppress_listing');
            $table->dropColumn('hide_title');
        });
    }
};
