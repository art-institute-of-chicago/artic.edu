<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->string('header_variation')->nullable();
            $table->string('header_cta_title')->nullable();
            $table->string('header_cta_button_label')->nullable();
            $table->string('header_cta_button_link')->nullable();
            $table->string('home_location_label')->nullable();
            $table->string('home_location_link')->nullable();
            $table->string('home_buy_tix_label')->nullable();
            $table->string('home_buy_tix_link')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn('header_variation');
            $table->dropColumn('header_cta_title');
            $table->dropColumn('header_cta_button_label');
            $table->dropColumn('header_cta_button_link');
            $table->dropColumn('home_location_label');
            $table->dropColumn('home_location_link');
            $table->dropColumn('home_buy_tix_label');
            $table->dropColumn('home_buy_tix_link');
        });
    }
};
