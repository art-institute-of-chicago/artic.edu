<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        // Drop table left by mistake
        Schema::dropIfExists('artwork_selection');
        Schema::dropIfExists('article_selection');

        Schema::create('article_selection', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'article', 'selection');
            $table->integer('position')->unsigned()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_selection');
    }
};
