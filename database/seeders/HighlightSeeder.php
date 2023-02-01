<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HighlightSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('selections')->update(['highlight_type' => 0]);
    }
}
