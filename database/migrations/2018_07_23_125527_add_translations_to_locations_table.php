<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranslationsToLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'location');
            $table->string('name')->nullable();
        });

        foreach (\App\Models\Location::all() as $location) {
            DB::table('location_translations')->insert([
                'locale' => 'en',
                'active' => true,
                'location_id' => $location->id,
                'name' => $location->name,
            ]);
        }

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_translations');
        Schema::table('locations', function (Blueprint $table) {
            $table->string('name')->nullable();
        });
    }
}
