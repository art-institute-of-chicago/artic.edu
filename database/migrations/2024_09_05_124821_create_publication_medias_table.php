<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publication_medias', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->string('uuid');
            $table->string('alt_text');
            $table->integer('width')->unsigned();
            $table->integer('height')->unsigned();
            $table->string('caption')->nullable();
            $table->string('filename')->nullable();
        });

        Schema::create('publication_mediables', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('publication_mediable_id')->nullable()->unsigned();
            $table->string('mediable_type')->nullable();
            $table->integer('publication_media_id')->unsigned();
            $table->integer('crop_x')->nullable();
            $table->integer('crop_y')->nullable();
            $table->integer('crop_w')->nullable();
            $table->integer('crop_h')->nullable();
            $table->string('role')->nullable();
            $table->string('crop')->nullable();
            $table->text('lqip_data')->nullable();
            $table->string('ratio')->nullable();
            $table->json('metadatas')->nullable();
            $table->string('locale', 7)->default($this->getCurrentLocale())->index();
            $table->index(['mediable_type', 'publication_mediable_id']);
        });    }

    public function down(): void
    {
        Schema::dropIfExists('publication_mediables');
        Schema::dropIfExists('publication_medias');
    }

    public function getCurrentLocale()
    {
        return getLocales()[0] ?? config('app.locale');
    }
};
