<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HighlightSeeder extends Seeder
{
    public function run(): void
    {
        // XXX I don't think this is necessary anymore. In the original migration a default was set for this field.
        DB::table('selections')->update(['highlight_type' => 0]);
    }
}
