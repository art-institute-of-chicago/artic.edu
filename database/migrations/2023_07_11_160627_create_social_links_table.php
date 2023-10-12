<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialLinksTable extends Migration
{
    public function up()
    {
        Schema::create('social_links', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('label')->nullable();
            $table->string('link')->nullable();
            $table->integer('position')->unsigned();
            $table->integer('page_id')->nullable();
            $table->foreignId('landing_page_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('social_links');
    }
}
