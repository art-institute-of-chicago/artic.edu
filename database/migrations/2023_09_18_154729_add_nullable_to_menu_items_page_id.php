<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->integer('page_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            //
        });
    }
};
