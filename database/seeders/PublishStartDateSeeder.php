<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublishStartDateSeeder extends Seeder
{
    private $tableNames = [
        'articles',
        'events',
        'selections',
    ];

    public function run(): void
    {
        foreach ($this->tableNames as $tableName) {
            DB::table($tableName)->where('published', 1)->update(['publish_start_date' => Carbon::now()]);
        }
    }
}
