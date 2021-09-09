<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorDisplayToArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->text('author_display')->nullable();
        });

        DB::table('articles')->update(['author_display' => DB::raw('author')]);

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('author');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->text('author')->nullable();
        });

        DB::table('articles')->update(['author' => DB::raw('author_display')]);

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('author_display');
        });
    }
}
