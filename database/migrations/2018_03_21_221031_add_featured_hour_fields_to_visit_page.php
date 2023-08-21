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
        Schema::table('pages', function (Blueprint $table) {
            $table->string('visit_hour_header')->nullable();
            $table->text('visit_hour_subheader')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('visit_hour_header');
            $table->dropColumn('visit_hour_subheader');
        });
    }
};
