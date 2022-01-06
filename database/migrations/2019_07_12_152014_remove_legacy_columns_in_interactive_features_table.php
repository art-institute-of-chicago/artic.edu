<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveLegacyColumnsInInteractiveFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interactive_features', function (Blueprint $table) {
            $table->dropColumn(['datahub_id', 'asset_library', 'content_bundle']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interactive_features', function (Blueprint $table) {

        });
    }
}
