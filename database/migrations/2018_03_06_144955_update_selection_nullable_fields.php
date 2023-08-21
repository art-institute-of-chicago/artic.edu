<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('selections', function (Blueprint $table) {
            $table->dropColumn('short_copy');
        });

        Schema::table('selections', function (Blueprint $table) {
            $table->text('short_copy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('selections', function (Blueprint $table) {
            $table->dropColumn('short_copy');
        });

        Schema::table('selections', function (Blueprint $table) {
            $table->text('short_copy');
        });
    }
};
