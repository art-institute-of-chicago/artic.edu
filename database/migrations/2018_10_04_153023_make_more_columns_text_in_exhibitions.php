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
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->text('exhibition_message')->change();
            $table->text('meta_title')->change();
            $table->text('hero_caption')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->string('exhibition_message')->change();
            $table->string('meta_title')->change();
            $table->string('hero_caption')->change();
        });
    }
};
