<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAltTypesAndAudiencesToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('events', function (Blueprint $table) {
            $anchor = Schema::hasColumn('events', 'type') ? 'type' : 'event_type';
            $table->json('alt_types')->nullable()->after($anchor);
            $table->json('alt_audiences')->nullable()->after('audience');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('alt_types');
            $table->dropColumn('alt_audiences');
        });

    }
}
