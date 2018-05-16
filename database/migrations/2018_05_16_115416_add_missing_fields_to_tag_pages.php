<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissingFieldsToTagPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->text('caption')->nullable();
            $table->text('intro')->nullable();
            $table->dropColumn('intro_copy')->nullable();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->text('caption')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('caption');
            $table->dropColumn('intro');
            $table->text('intro_copy')->nullable();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('caption');
        });
    }
}
