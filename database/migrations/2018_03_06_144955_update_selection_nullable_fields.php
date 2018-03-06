<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSelectionNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('selections', function (Blueprint $table) {
            $table->dropColumn('short_copy');
        });

        Schema::table('selections', function (Blueprint $table) {
            $table->text('short_copy')->nullable();
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
            $table->dropColumn('short_copy');
        });

        Schema::table('selections', function (Blueprint $table) {
            $table->text('short_copy');
        });
    }
}
