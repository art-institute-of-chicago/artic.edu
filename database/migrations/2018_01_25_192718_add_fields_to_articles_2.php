<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToArticles2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            if (env('APP_ENV') != 'testing') {
                $table->string('type')->nullable();
            }
            $table->string('heading')->nullable();
            $table->dropColumn('copy');
            $table->text('citation')->nullable();
            $table->integer('layout_type')->default(0);
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
            if (env('APP_ENV') != 'testing') {
                $table->dropColumn('type');
            }
            $table->dropColumn('heading');
            $table->dropColumn('layout_type');
            $table->dropColumn('citation');
            $table->text('copy')->nullable();
        });
    }
}
