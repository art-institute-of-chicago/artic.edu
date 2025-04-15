<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('shop_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->text('datahub_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_items');
    }
};
