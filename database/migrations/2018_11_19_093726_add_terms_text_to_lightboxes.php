<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTermsTextToLightboxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lightboxes', function (Blueprint $table) {
            $table->text('terms_text')->nullable()->after('lightbox_button_text');
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
            $table->dropColumn('terms_text');
        });
    }
}
