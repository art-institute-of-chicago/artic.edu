<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement("UPDATE blocks SET blockable_type='genericPages' where blockable_type='App\Models\GenericPage'");
        DB::statement("UPDATE related SET subject_type='genericPages' where subject_type='App\Models\GenericPage'");
        DB::statement("UPDATE related SET related_type='genericPages' where related_type='App\Models\GenericPage'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='genericPages' where api_relatable_type='App\Models\GenericPage'");
        DB::statement("UPDATE mediables SET mediable_type='genericPages' where mediable_type='App\Models\GenericPage'");
    }

    public function down(): void
    {
        DB::statement("UPDATE blocks SET blockable_type='App\Models\GenericPage' where blockable_type='genericPages'");
        DB::statement("UPDATE related SET subject_type='App\Models\GenericPage' where subject_type='genericPages'");
        DB::statement("UPDATE related SET related_type='App\Models\GenericPage' where related_type='genericPages'");
        DB::statement("UPDATE api_relatables SET api_relatable_type='App\Models\GenericPage' where api_relatable_type='genericPages'");
        DB::statement("UPDATE mediables SET mediable_type='App\Models\GenericPage' where mediable_type='genericPages'");
    }
};
