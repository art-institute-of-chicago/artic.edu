<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLightboxesTable extends Migration
{
    public function up()
    {
        Schema::create('lightboxes', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->text('title')->nullable(); // admin title
            $table->text('header')->nullable();
            $table->text('body')->nullable();
            $table->timestamp('lightbox_start_date')->nullable();
            $table->timestamp('lightbox_end_date')->nullable();
            $table->text('lightbox_button_text')->nullable();
            $table->text('action_url')->nullable();
            $table->text('form_id')->nullable();
            $table->text('form_token')->nullable();
            $table->text('form_tlc_source')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lightboxes');
    }
}
