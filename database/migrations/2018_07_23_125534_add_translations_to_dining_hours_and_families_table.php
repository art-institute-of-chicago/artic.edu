<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranslationsToDiningHoursAndFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dining_hour_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'dining_hour');
            $table->string('name')->nullable();
            $table->text('hours')->nullable();
        });

        foreach (\App\Models\DiningHour::all() as $diningHour) {
            DB::table('dining_hour_translations')->insert([
                'locale' => 'en',
                'active' => true,
                'dining_hour_id' => $diningHour->id,
                'name' => $diningHour->name,
                'hours' => $diningHour->hours,
            ]);
        }

        Schema::table('dining_hours', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('hours');
        });

        Schema::create('family_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'family');
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('link_label')->nullable();
        });

        foreach (\App\Models\Family::all() as $family) {
            DB::table('family_translations')->insert([
                'locale' => 'en',
                'active' => true,
                'family_id' => $family->id,
                'title' => $family->title,
                'text' => $family->text,
                'link_label' => $family->link_label,
            ]);
        }

        Schema::table('families', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('text');
            $table->dropColumn('link_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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
}
