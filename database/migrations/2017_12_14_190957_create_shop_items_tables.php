<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('shop_items', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('datahub_id');
            $table->string('name');
        });

        Schema::create('shop_itemized', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_itemizable_type');
            $table->integer('shop_itemizable_id')->unsigned();
            $table->integer('shop_item_id')->unsigned();
            $table->index(['shop_itemizable_type', 'shop_itemizable_id']);

            $table->integer('position')->unsigned();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_itemized');
        Schema::dropIfExists('shop_items');
    }
};
