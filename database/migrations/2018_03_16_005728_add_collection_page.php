<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Page;

class AddCollectionPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $page = Page::firstOrNew(['type' => 6], [
            'position' => 6,
            'published' => 1,
            'title' => 'Collection'
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
        $page = Page::where('type', 6)->first();
        if ($page) {
            $page->destroy();
        }
    }
}
