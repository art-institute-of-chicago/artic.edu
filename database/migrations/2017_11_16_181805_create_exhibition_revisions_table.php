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
        Schema::create('exhibition_revisions', function (Blueprint $table) {
            createDefaultTableFields($table, false, false);
            $table->json('payload');
            $table->integer('exhibition_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('exhibition_id')->references('id')->on('exhibitions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('exhibition_revisions');
    }
};
