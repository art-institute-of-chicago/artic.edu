<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventSeriesFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // It's tempting to determine this from relationship calls,
            // but it's possible that the event might have all this info
            // filled out and saved, but then be removed from the series
            $table->boolean('add_to_event_email_series')->default(false)->after('event_type');
            $table->text('join_url')->nullable()->after('add_to_event_email_series');
            $table->text('survey_url')->nullable()->after('join_url');
            $table->boolean('is_presented_by_affiliate')->default(false)->after('survey_url');
            $table->integer('entrance')->unsigned()->nullable()->after('is_presented_by_affiliate');
        });

        Schema::create('email_series', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title');
            $table->boolean('show_affiliate_member')->default(false);
            $table->text('affiliate_member_copy')->nullable();
            $table->boolean('show_member')->default(false);
            $table->text('member_copy')->nullable();
            $table->boolean('show_sustaining_fellow')->default(false);
            $table->text('sustaining_fellow_copy')->nullable();
            $table->boolean('show_non_member')->default(false);
            $table->text('non_member_copy')->nullable();
        });

        // 90-60-30 uses short description as default

        Schema::create('event_email_series', function (Blueprint $table) {
            createDefaultTableFields($table, false, false);
            $table->integer('event_id')->unsigned()->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->integer('email_series_id')->unsigned()->index();
            $table->foreign('email_series_id')->references('id')->on('email_series')->onDelete('cascade');
            $table->boolean('send_affiliate_member')->default(false);
            $table->text('affiliate_member_copy')->nullable();
            $table->boolean('send_member')->default(false);
            $table->text('member_copy')->nullable();
            $table->boolean('send_sustaining_fellow')->default(false);
            $table->text('sustaining_fellow_copy')->nullable();
            $table->boolean('send_non_member')->default(false);
            $table->text('non_member_copy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('add_to_event_email_series');
            $table->dropColumn('join_url');
            $table->dropColumn('survey_url');
            $table->dropColumn('is_presented_by_affiliate');
            $table->dropColumn('entrance');
        });

        Schema::dropIfExists('event_email_series');
        Schema::dropIfExists('email_series');
    }
}
