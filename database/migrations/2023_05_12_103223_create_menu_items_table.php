<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->integer('label');
            $table->string('position');
            $table->string('link');
            $table->integer('page_id');
            $table->integer('landing_page_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
