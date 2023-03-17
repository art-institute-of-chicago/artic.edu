<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIssuearticlesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('issue_articles');
    }

    public function down()
    {
        //
    }
}