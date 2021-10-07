<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturedHoursTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_hour_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'featured_hour');
            $table->string('title')->nullable();
            $table->text('copy')->nullable();
        });

        foreach (\App\Models\FeaturedHour::all() as $hour) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('featured_hour_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'featured_hour_id' => $hour->id,
                    'title' => $hour->title,
                    'copy' => $hour->copy,
                ]);
            }
        }

        Schema::table('featured_hours', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('copy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('featured_hour_translations');
        Schema::table('featured_hours', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('copy')->nullable();
        });
    }
}
