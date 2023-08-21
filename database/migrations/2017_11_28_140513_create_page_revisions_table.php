<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('page_revisions', function (Blueprint $table) {
            createDefaultTableFields($table, false, false);
            $table->json('payload');
            $table->integer('page_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
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
        Schema::dropIfExists('page_revisions');
    }
};
