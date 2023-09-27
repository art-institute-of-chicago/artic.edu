<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function up()
    {
        Schema::create('custom_tours_landing_page_items', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('title', 200)->nullable();

            $table->text('tour_id')->nullable();
        });

        Schema::create('custom_tours_landing_page_item_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'custom_tours_landing_page_item');
        });

        Schema::create('custom_tours_landing_page_item_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'custom_tours_landing_page_item');
        });
    }

    public function down()
    {
        Schema::dropIfExists('custom_tours_landing_page_item_revisions');
        Schema::dropIfExists('custom_tours_landing_page_item_slugs');
        Schema::dropIfExists('custom_tours_landing_page_items');
    }
};
