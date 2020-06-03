<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsFromMagazineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('magazine_items', function (Blueprint $table) {
            $table->dropColumn('tag');
            $table->dropColumn('title');
            $table->dropColumn('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('magazine_items', function (Blueprint $table) {
            $table->string('tag')->nullable();
            $table->text('title')->nullable();
            $table->text('url')->nullable();
        });
    }
}
