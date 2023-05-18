<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMenuItemsTable extends Migration
{
    public function up()
    {
        DB::statement('CREATE SEQUENCE menu_items_id_seq');

        DB::statement('CREATE TABLE menu_items (
            id INTEGER DEFAULT nextval(\'menu_items_id_seq\') PRIMARY KEY,
            created_at TIMESTAMP,
            updated_at TIMESTAMP,
            deleted_at TIMESTAMP,
            published BOOLEAN,
            position INTEGER,
            label VARCHAR(255),
            link VARCHAR(255),
            page_id INTEGER,
            landing_page_id INTEGER
        )');
    }

    public function down()
    {
        DB::statement('DROP TABLE IF EXISTS menu_items');
        DB::statement('DROP SEQUENCE IF EXISTS menu_items_id_seq');
    }
}
