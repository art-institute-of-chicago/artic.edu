<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFeaturedContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_page', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'article', 'page');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });

        Schema::create('digital_catalog_page', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'digital_catalog', 'page');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });

        Schema::create('generic_page_page', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'generic_page', 'page');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });

        Schema::create('page_printed_catalog', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'page', 'printed_catalog');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });

        Schema::create('page_scholarly_journal', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'page', 'scholarly_journal');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_page');
        Schema::dropIfExists('digital_catalog_page');
        Schema::dropIfExists('generic_page_page');
        Schema::dropIfExists('page_printed_catalog');
        Schema::dropIfExists('page_scholarly_journal');
    }
}
