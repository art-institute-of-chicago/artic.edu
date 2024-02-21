<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::rename('custom_tours_item_revisions', 'my_museum_tour_item_revisions');
        Schema::rename('custom_tours_item_slugs', 'my_museum_tour_item_slugs');
        Schema::rename('custom_tours_items', 'my_museum_tour_items');

        Schema::table('my_museum_tour_item_revisions', function (Blueprint $table) {
            $table->renameColumn('custom_tours_item_id', 'my_museum_tour_item_id');
        });

        Schema::table('my_museum_tour_item_slugs', function (Blueprint $table) {
            $table->renameColumn('custom_tours_item_id', 'my_museum_tour_item_id');
        });
    }

    public function down(): void
    {
        Schema::rename('my_museum_tour_item_revisions', 'custom_tours_item_revisions');
        Schema::rename('my_museum_tour_item_slugs', 'custom_tours_item_slugs');
        Schema::rename('my_museum_tour_items', 'custom_tours_items');

        Schema::table('custom_tours_item_revisions', function (Blueprint $table) {
            $table->renameColumn('my_museum_tour_item_id', 'custom_tours_item_id');
        });

        Schema::table('custom_tours_item_slugs', function (Blueprint $table) {
            $table->renameColumn('my_museum_tour_item_id', 'custom_tours_item_id');
        });
    }
};
