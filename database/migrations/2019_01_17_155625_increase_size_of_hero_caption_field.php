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
        Schema::table('events', function (Blueprint $table) {
            $table->text('hero_caption')->nullable()->change();
        });

        Schema::table('selections', function (Blueprint $table) {
            $table->text('hero_caption')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('hero_caption')->nullable()->change();
        });

        Schema::table('selections', function (Blueprint $table) {
            $table->string('hero_caption')->nullable()->change();
        });
    }
};
