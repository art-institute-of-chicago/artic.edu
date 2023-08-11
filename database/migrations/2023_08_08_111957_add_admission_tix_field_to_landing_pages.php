<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdmissionTixFieldToLandingPages extends Migration
{
    public function up()
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->string('visit_admission_members_link')->nullable();
            $table->string('visit_admission_members_label')->nullable();
            $table->string('visit_admission_tix_link')->nullable();
            $table->string('visit_admission_tix_label')->nullable();
        });
    }

    public function down()
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn('visit_admission_members_link');
            $table->dropColumn('visit_admission_members_label');
            $table->dropColumn('visit_admission_tix_link');
            $table->dropColumn('visit_admission_tix_label');
        });
    }
}
