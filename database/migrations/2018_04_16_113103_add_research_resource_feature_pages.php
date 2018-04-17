<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResearchResourceFeaturePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_resource_feature_page', function (Blueprint $table) {
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
        Schema::dropIfExists('research_resource_feature_page');
    }
}
