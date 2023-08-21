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
        Schema::create('dining_hour_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'dining_hour');
            $table->string('name')->nullable();
            $table->text('hours')->nullable();
        });

        Schema::table('dining_hours', function (Blueprint $table) {
            $table->dropColumn(['name', 'hours']);
        });

        Schema::create('family_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'family');
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('link_label')->nullable();
        });

        Schema::table('families', function (Blueprint $table) {
            $table->dropColumn(['title', 'text', 'link_label']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('dining_hour_translations');
        Schema::dropIfExists('family_translations');
        Schema::table('families', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('link_label')->nullable();
        });
        Schema::table('dining_hours', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->text('hours')->nullable();
        });
    }
};
