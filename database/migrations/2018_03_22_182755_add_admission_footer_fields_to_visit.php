<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdmissionFooterFieldsToVisit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->text('visit_admission_description')->nullable();
            $table->string('visit_buy_tickets_label')->nullable();
            $table->string('visit_buy_tickets_link')->nullable();
            $table->string('visit_become_member_label')->nullable();
            $table->string('visit_become_member_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('visit_admission_description');
            $table->dropColumn('visit_buy_tickets_label');
            $table->dropColumn('visit_buy_tickets_link');
            $table->dropColumn('visit_become_member_label');
            $table->dropColumn('visit_become_member_link');
        });
    }
}
