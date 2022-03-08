<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameClosureTable extends Migration
{
    public function up()
    {
        Schema::rename('closures', 'building_closures');
    }

    public function down()
    {
        Schema::rename('building_closures', 'closures');
    }
}
