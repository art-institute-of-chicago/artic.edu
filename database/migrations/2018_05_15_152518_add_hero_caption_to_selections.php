<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeroCaptionToSelections extends Migration
{

    public function up()
     {
         Schema::table('selections', function (Blueprint $table) {
             $table->string('hero_caption')->nullable();
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::table('selections', function (Blueprint $table) {
             $table->dropColumn('hero_caption');
         });
     }

}
