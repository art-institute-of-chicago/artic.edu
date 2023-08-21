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
        Schema::table('experiences', function (Blueprint $table) {
            $table->renameColumn('media_title', 'end_headline');
            $table->string('end_copy')->nullable()->default('The End');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('experiences', function (Blueprint $table) {
            $table->renameColumn('end_headline', 'media_title');
            $table->dropColumn('end_copy');
        });
    }
};
