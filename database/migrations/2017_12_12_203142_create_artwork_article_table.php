<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('article_artwork', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'article', 'artwork');
            $table->integer('position')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('article_artwork');
    }
};
