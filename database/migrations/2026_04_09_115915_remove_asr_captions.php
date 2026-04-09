<?php

use App\Models\Caption;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration
{
    public function up(): void
    {
        Caption::where('kind', 'asr')->forceDelete();
    }

    public function down(): void
    {
        // no return
    }
};
