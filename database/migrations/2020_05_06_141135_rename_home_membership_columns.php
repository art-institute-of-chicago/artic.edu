<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameHomeMembershipColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->renameColumn('home_membership_module_headline', 'home_cta_module_headline');
            $table->renameColumn('home_membership_module_short_copy', 'home_cta_module_short_copy');
            $table->renameColumn('home_membership_module_button_text', 'home_cta_module_button_text');
            $table->renameColumn('home_membership_module_url', 'home_cta_module_url');
        });

        DB::table('mediables')->where('role', 'home_membership_module_image')->update(['role' => 'home_cta_module_image']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->renameColumn('home_cta_module_headline', 'home_membership_module_headline');
            $table->renameColumn('home_cta_module_short_copy', 'home_membership_module_short_copy');
            $table->renameColumn('home_cta_module_button_text', 'home_membership_module_button_text');
            $table->renameColumn('home_cta_module_url', 'home_membership_module_url');
        });

        DB::table('mediables')->where('role', 'home_cta_module_image')->update(['role' => 'home_membership_module_image']);
    }
}
