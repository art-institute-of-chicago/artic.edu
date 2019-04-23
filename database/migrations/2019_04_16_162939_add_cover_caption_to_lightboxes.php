<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoverCaptionToLightboxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lightboxes', function (Blueprint $table) {
            $table->text('cover_caption')->nullable()->after('terms_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lightboxes', function (Blueprint $table) {
            $table->dropColumn('cover_caption');
        });
    }
}
