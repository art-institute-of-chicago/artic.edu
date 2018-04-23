<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_terms', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('local_subtype')->nullable();
            $table->string('local_title')->nullable();
            $table->boolean('featuredll')->nullable();

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
        Schema::dropIfExists('category_terms');
    }
}
