<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement("UPDATE blocks SET blockable_type='landingPages' where blockable_type='App\Models\LandingPage'");
        DB::statement("UPDATE related SET subject_type='landingPages' where subject_type='App\Models\LandingPage'");
        DB::statement("UPDATE related SET related_type='landingPages' where related_type='App\Models\LandingPage'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='landingPages' where api_relatable_type='App\Models\LandingPage'");
        DB::statement("UPDATE mediables SET mediable_type='landingPages' where mediable_type='App\Models\LandingPage'");
    }

    public function down(): void
    {
        DB::statement("UPDATE blocks SET blockable_type='App\Models\LandingPage' where blockable_type='landingPages'");
        DB::statement("UPDATE related SET subject_type='App\Models\LandingPage' where subject_type='landingPages'");
        DB::statement("UPDATE related SET related_type='App\Models\LandingPage' where related_type='landingPages'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='App\Models\LandingPage' where api_relatable_type='landingPages'");
        DB::statement("UPDATE mediables SET mediable_type='App\Models\LandingPage' where mediable_type='landingPages'");
    }
};
