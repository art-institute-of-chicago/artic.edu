<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ad_campaigns', function (Blueprint $table) {
            createDefaultTableFields($table, publishDates: true);
            $table->integer('position')->unsigned()->nullable();
            $table->string('title', 200)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('header', 200)->nullable();
            $table->text('description')->nullable();
            $table->string('destination_url', 200)->nullable();
            $table->string('destination_label', 200)->nullable();
        });
        Schema::create('ad_campaign_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'ad_campaign');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ad_campaign_revisions');
        Schema::dropIfExists('ad_campaigns');
    }
};
