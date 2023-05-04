<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPositionToResourceCategories extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE resource_categories ADD COLUMN position integer');
    }

    public function down()
    {
        DB::statment('ALTER TABLE resources_categories DROP COLUMN position');
    }
}
