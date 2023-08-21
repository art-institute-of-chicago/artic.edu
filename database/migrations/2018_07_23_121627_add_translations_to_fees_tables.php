<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('fee_age_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'fee_age');
            $table->string('title')->nullable();
        });

        Schema::create('fee_category_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'fee_category');
            $table->string('title')->nullable();
            $table->string('tooltip')->nullable();
        });

        Schema::table('fee_categories', function (Blueprint $table) {
            $table->dropColumn(['title', 'tooltip']);
        });

        Schema::table('fee_ages', function (Blueprint $table) {
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
        Schema::dropIfExists('fee_age_translations');
        Schema::dropIfExists('fee_category_translations');
        Schema::table('fee_categories', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('tooltip')->nullable();
        });

        Schema::table('fee_ages', function (Blueprint $table) {
            $table->string('title')->nullable();
        });
    }
};
