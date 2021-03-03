<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsInMagazineToMagazinables extends Migration
{
    private $tables = [
        'articles',
        'experiences',
        'selections',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->boolean('is_in_magazine')->default(false)->nullable();
            });

            DB::table($tableName)->update(['is_in_magazine' => DB::raw('is_unlisted')]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('is_in_magazine');
            });
        }
    }
}
