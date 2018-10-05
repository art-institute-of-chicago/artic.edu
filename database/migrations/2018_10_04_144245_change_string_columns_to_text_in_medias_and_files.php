<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStringColumnsToTextInMediasAndFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medias', function (Blueprint $table) {
            $table->text('uuid')->change();
            $table->text('alt_text')->nullable(true)->change();
            $table->text('caption')->change();
            $table->text('filename')->change();
        });

        Schema::table('files', function (Blueprint $table) {
            $table->text('uuid')->change();
            $table->text('filename')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medias', function (Blueprint $table) {
            $table->string('uuid')->change();
            $table->string('alt_text')->nullable(false)->change();
            $table->string('caption')->change();
            $table->string('filename')->change();
        });

        Schema::table('files', function (Blueprint $table) {
            $table->string('uuid')->change();
            $table->string('filename')->change();
        });
    }
}
