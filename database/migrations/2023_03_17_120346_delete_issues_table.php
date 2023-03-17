<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteIssuesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('issues');
    }

    public function down()
    {

    }
}
