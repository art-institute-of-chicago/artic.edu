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
        'highlights',
    ];

    public function run(): void
    {
        // XXX I think I was mistaken, the migration this came from:
        // https://github.com/art-institute-of-chicago/artic.edu/pull/5/files#diff-7870073f898417541722fbad31dd4e28f0d780f7c9b28a1b8773ca2852067665
        // looks like it's renaming/recasting the published column. nikhil, is that correct?
        foreach ($this->tableNames as $tableName) {
            DB::table($tableName)->where('published', 1)->update(['publish_start_date' => Carbon::now()]);
        }
    }
}
