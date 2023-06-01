<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenuItemsTable extends Migration
{
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('label')->change();
            $table->integer('page_id')->nullable()->change();
            $table->integer('landing_page_id')->nullable()->change();
        });
    }

    public function down()
    {
    }
}
