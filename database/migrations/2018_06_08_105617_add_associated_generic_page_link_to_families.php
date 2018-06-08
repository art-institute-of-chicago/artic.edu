<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssociatedGenericPageLinkToFamilies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('families', function (Blueprint $table) {
            $table->string('associated_generic_page_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('families', function (Blueprint $table) {
            $table->dropColumn('associated_generic_page_link');
        });
    }
}
