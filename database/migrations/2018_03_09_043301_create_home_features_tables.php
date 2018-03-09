<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHomeFeaturesTables extends Migration
{
    public function up()
    {
        Schema::create('home_features', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true);
            $table->string('title')->nullable();
        });

        // Schema::create('artwork_home_feature', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->timestamps();

        //     createDefaultRelationshipTableFields($table, 'artwork', 'home_feature');
        //     $table->integer('position')->unsigned()->index();
        // });

        // Schema::create('exhibition_home_feature', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->timestamps();

        //     createDefaultRelationshipTableFields($table, 'exhibition', 'home_feature');
        //     $table->integer('position')->unsigned()->index();
        // });

        Schema::create('article_home_feature', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'article', 'home_feature');
            $table->integer('position')->unsigned()->index();
        });

        Schema::create('event_home_feature', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'event', 'home_feature');
            $table->integer('position')->unsigned()->index();
        });
    }

    public function down()
    {
        // Schema::dropIfExists('exhibition_home_feature');
        Schema::dropIfExists('event_home_feature');
        // Schema::dropIfExists('artwork_home_feature');
        Schema::dropIfExists('article_home_feature');
        Schema::dropIfExists('home_features');
    }
}
