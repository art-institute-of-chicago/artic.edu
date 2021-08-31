<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleDisplayField extends Migration
{

    // We reviewed this list and chose which items should have italics etc.
    // https://stackoverflow.com/questions/193780/how-to-find-all-the-tables-in-mysql-with-specific-column-names-in-them
    private $tables = [
        'articles',
        'digital_catalogs',
        'educator_resources',
        'events',
        'exhibition_press_rooms',
        'exhibitions',
        'generic_pages',
        'press_releases',
        'printed_catalogs',
        'selections',
    ];

    public function up()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->text('title_display')->nullable()->after('title');
            });
        }
    }


    public function down()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('title_display');
            });
        }
    }
}
