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
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn(['name', 'biography']);
        });
        Schema::table('artists', function (Blueprint $table) {
            $table->string('also_known_as')->nullable();
            $table->string('intro_copy')->nullable();
            $table->string('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->text('biography')->nullable();
            $table->dropColumn('also_known_as');
            $table->dropColumn('intro_copy');
            $table->dropColumn('title');
        });
    }
};
