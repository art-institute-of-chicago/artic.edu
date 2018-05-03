<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_contacts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('prefix');
            $table->string('first_name');
            $table->string('middle_initial')->nullable();
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country');

            $table->date('visit_date');
            $table->string('days_class_meets');
            $table->string('comments')->nullable();
            $table->string('type_of_visit');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_contacts');
    }
}
