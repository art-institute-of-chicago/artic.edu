<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Hour;

class RefactorHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hours', function (Blueprint $table) {
            $table->dropColumn('opening_time');
            $table->dropColumn('closing_time');
            $table->dropColumn('day_of_week');
            $table->dropColumn('closed');
        });

        Schema::table('hours', function (Blueprint $table) {
            $table->datetime('valid_from')->nullable();
            $table->datetime('valid_through')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->boolean('published')->default(false);
        });

        Hour::truncate();

        $hour = new Hour;
        $hour->type = 0;        // Museum
        $hour->title = "Open daily 10:30–5:00, Thursdays until 8:00";
        $hour->url = "visit";
        $hour->published = true;
        $hour->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('hours', function (Blueprint $table) {
            $table->dropColumn('valid_from');
            $table->dropColumn('valid_through');
            $table->dropColumn('title');
            $table->dropColumn('url');
        });

        Schema::table('hours', function (Blueprint $table) {
            $table->datetime('opening_time')->nullable();
            $table->datetime('closing_time')->nullable();
            $table->integer('day_of_week')->default(1);
            $table->boolean('closed')->default(false);
        });
    }
}
