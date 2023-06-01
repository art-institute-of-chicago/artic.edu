<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFaqsTable extends Migration
{
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->text('question')->nullable();
            $table->text('answer')->nullable();  
        });
    }

    public function down()
    {
        Schema::dropColumns('faqs', ['question', 'answer']);
    }
}
