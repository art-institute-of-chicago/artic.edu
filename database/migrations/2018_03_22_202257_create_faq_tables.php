<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->integer('position')->unsigned()->nullable();

            $table->integer('page_id')->unsigned();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('CASCADE');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
