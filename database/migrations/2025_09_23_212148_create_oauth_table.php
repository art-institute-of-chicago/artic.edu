<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('oauth', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');
            $table->string('provider')->nullable();
            $table->string('authorization_code', 256)->unique();
            $table->json('access_token');
        });
        Schema::create('youtube_service_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('errored_at')->nullable();
            $table->integer('requests')->nullable();
            $table->integer('usage')->nullable();
            $table->string('message')->nullable();
            $table->json('error')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('youtube_service_sessions');
        Schema::dropIfExists('oauth');
    }
};
