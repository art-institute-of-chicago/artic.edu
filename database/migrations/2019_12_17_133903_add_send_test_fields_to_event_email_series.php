<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->boolean('send_affiliate_test')->default(false)->after('nonmember_copy');
            $table->boolean('send_member_test')->default(false)->after('send_affiliate_test');
            $table->boolean('send_sustaining_fellow_test')->default(false)->after('send_member_test');
            $table->boolean('send_nonmember_test')->default(false)->after('send_sustaining_fellow_test');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->dropColumn([
                'send_affiliate_test',
                'send_member_test',
                'send_sustaining_fellow_test',
                'send_nonmember_test',
            ]);
        });
    }
};
