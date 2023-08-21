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
        Schema::create('faq_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'faq');
            $table->string('title')->nullable();
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_translations');
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('title')->nullable();
        });
    }
};
