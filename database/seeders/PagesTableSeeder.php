<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (Page::$types as $type => $name) {
            $page = Page::firstOrNew(['type' => $type], [
                'position' => $type,
                'published' => 1,
                'title' => $name
            ]);

            $page->save();
        }

        Page::create([
            'published' => true,
            'position' => 7,
            'title' => 'Research and Resources',
            'type' => 7,
        ]);

        Page::create([
            'published' => true,
            'position' => 8,
            'title' => 'Articles and Publications',
            'type' => 8,
        ]);

        Page::create([
            'published' => true,
            'position' => 0,
            'title' => 'Home',
            'type' => 0,
        ]);

        Page::create([
            'published' => true,
            'position' => 1,
            'title' => 'Exhibitions and Events',
            'type' => 1,
        ]);

        Page::create([
            'published' => true,
            'position' => 2,
            'title' => 'Art and Ideas',
            'type' => 2,
        ]);

        Page::create([
            'published' => true,
            'position' => 3,
            'title' => 'Visit',
            'type' => 3,
        ]);

        Page::create([
            'published' => true,
            'position' => 4,
            'title' => 'Articles',
            'type' => 4,
        ]);

        Page::create([
            'published' => true,
            'position' => 5,
            'title' => 'Exhibition History',
            'type' => 5,
        ]);

        Page::create([
            'published' => true,
            'position' => 6,
            'title' => 'Collection',
            'type' => 6,
        ]);
    }
}
