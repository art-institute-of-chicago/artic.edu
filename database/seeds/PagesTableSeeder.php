<?php

use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesTableSeeder extends Seeder
{
    public function run()
    {
        foreach(Page::$types as $type => $name) {
            $page = Page::firstOrNew(['type' => $type], [
                'position' => $type,
                'published' => 1,
                'title' => $name
            ]);

            $page->save();
        }
    }
}
