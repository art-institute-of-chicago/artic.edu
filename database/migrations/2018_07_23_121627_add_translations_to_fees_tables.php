<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranslationsToFeesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

        foreach (\App\Models\FeeCategory::all() as $feeCategory) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('fee_category_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'fee_category_id' => $feeCategory->id,
                    'title' => $feeCategory->title,
                    'tooltip' => $feeCategory->tooltip,
                ]);
            }
        }

        foreach (\App\Models\FeeAge::all() as $feeAge) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('fee_age_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'fee_age_id' => $feeAge->id,
                    'title' => $feeAge->title,
                ]);
            }
        }

        Schema::table('fee_categories', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('tooltip');
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
    public function down()
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
}
