<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeroCaptionToDigitalPublications extends Migration
{
    public function up()
    {
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->text('hero_caption')->nullable()->after('listing_description');
        });
    }

    public function down()
    {
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->dropColumn('hero_caption');
        });
    }
}
