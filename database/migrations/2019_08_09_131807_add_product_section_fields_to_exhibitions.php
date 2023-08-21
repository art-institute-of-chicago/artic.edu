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
            $table->text('product_section_title')->nullable();
            $table->text('product_section_title_link_label')->nullable();
            $table->text('product_section_title_link_href')->nullable();
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
            $table->dropColumn([
                'product_section_title',
                'product_section_title_link_label',
                'product_section_title_link_href',
            ]);
        });
    }
};
