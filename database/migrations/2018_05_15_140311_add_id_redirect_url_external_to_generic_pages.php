<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdRedirectUrlExternalToGenericPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generic_pages', function (Blueprint $table) {
            $table->boolean('is_redirect_url_external')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generic_pages', function (Blueprint $table) {
            $table->dropColumn('is_redirect_url_external');
        });
    }
}
