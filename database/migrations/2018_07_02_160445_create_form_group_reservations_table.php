<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormGroupReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_group_reservations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('group_name')->nullable();
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();

            $table->date('visit_date')->nullable();
            $table->date('visit_time')->nullable();

            $table->integer('no_of_adults')->nullable();
            $table->integer('no_of_students')->nullable();
            $table->integer('no_of_seniors')->nullable();

            $table->string('dining_option')->nullable();

            $table->integer('no_of_audio_tours')->nullable();

            $table->string('topic')->nullable();

            $table->string('needs')->nullable();

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
        Schema::dropIfExists('form_group_reservations');
    }
}
