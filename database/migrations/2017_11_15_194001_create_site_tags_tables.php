<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('site_tagged', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_taggable_type');
            $table->integer('site_taggable_id')->unsigned();
            $table->integer('site_tag_id')->unsigned();
            $table->index(['site_taggable_type', 'site_taggable_id']);
        });

        Schema::create('site_tags', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });

        Schema::create('site_tag_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'site_tag');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_tagged');
        Schema::dropIfExists('site_tag_slugs');
        Schema::dropIfExists('site_tags');
    }
};
