<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_relatables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('api_relatable_type');
            $table->integer('api_relatable_id')->unsigned();
            $table->index(['api_relatable_type', 'api_relatable_id']);
            $table->integer('api_relation_id')->unsigned();
            $table->integer('position')->unsigned();
            $table->string('relation');
            $table->timestamps();
        });

        Schema::create('api_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('datahub_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_relatables');
        Schema::dropIfExists('api_relations');
    }
}
