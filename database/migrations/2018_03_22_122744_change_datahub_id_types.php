<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDatahubIdTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('gallery_slugs');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('department_slugs');
        Schema::dropIfExists('departments');

        Schema::create('departments', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);

            $table->text('intro')->nullable();
            $table->string('datahub_id');
        });

        Schema::create('department_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'department');
        });

        Schema::create('galleries', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);

            $table->text('intro')->nullable();
            $table->integer('datahub_id')->unsigned();
        });

        Schema::create('gallery_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'gallery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
