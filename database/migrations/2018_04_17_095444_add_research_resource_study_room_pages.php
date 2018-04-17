<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResearchResourceStudyRoomPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_resource_study_room_pages', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'generic_page', 'page');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });

        Schema::create('research_resource_study_room_more_pages', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'generic_page', 'page');
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
        Schema::dropIfExists('research_resource_study_room_more_pages');
        Schema::dropIfExists('research_resource_study_room_pages');
    }
}
