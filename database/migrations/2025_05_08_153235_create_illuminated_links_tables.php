<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('illuminated_links', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200);
            $table->string('url', 200);
            $table->text('description')->nullable();
        });

        Schema::create('illuminated_link_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'illuminated_link');
        });
    }

    public function down()
    {
        Schema::dropIfExists('illuminated_link_revisions');
        Schema::dropIfExists('illuminated_links');
    }
};
