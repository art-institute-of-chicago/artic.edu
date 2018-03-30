<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Page;

class AddArticlesAndPublicationsPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $type = 8;
        $name = Page::$types[$type];

        $page = Page::firstOrNew(['type' => $type], [
            'position' => $type,
            'published' => 1,
            'title' => $name
        ]);

        $page->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
