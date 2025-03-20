<?php

use A17\Twill\Models\Media;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table(config('twill.mediables_table', 'twill_mediables'))->where('mediable_type', 'A17\Twill\Models\Block')->get()->each(function ($mediable) {
            $mediable->mediable_type = 'blocks';

            DB::table(config('twill.mediables_table', 'twill_mediables'))->where('id', $mediable->id)->update((array) $mediable);
        });
    }

    public function down(): void
    {
        //
    }
};
