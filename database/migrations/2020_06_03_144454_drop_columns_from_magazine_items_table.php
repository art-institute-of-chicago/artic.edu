<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('magazine_items', function (Blueprint $table) {
            $table->dropColumn(['tag', 'title', 'url']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('magazine_items', function (Blueprint $table) {
            $table->string('tag')->nullable();
            $table->text('title')->nullable();
            $table->text('url')->nullable();
        });
    }
};
