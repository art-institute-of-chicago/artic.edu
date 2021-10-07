<?php

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;

class AddBasicPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (App::environment('testing')) {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
