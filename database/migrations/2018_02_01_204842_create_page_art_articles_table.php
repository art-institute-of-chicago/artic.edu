<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('page_art_article', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'page', 'article');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_art_article');
    }
};
