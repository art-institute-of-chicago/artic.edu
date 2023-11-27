<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->text('header_custom_tours_text')->nullable();
            $table->string('header_custom_tours_primary_button_label')->nullable();
            $table->string('header_custom_tours_primary_button_link')->nullable();
            $table->string('header_custom_tours_secondary_button_label')->nullable();
            $table->string('header_custom_tours_secondary_button_link')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn('header_custom_tours_text');
            $table->dropColumn('header_custom_tours_primary_button_label');
            $table->dropColumn('header_custom_tours_primary_button_link');
            $table->dropColumn('header_custom_tours_secondary_button_label');
            $table->dropColumn('header_custom_tours_secondary_button_link');
        });
    }
};
