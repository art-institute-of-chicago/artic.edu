<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);

            $table->text('intro')->nullable();
            $table->integer('datahub_id')->unsigned();
        });

        Schema::create('department_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'department');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
        Schema::dropIfExists('department_slugs');
    }
}
