<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\GenericPage;

class CreateMagazineGenericPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $page = new GenericPage;
        $page->title = 'Member Magazine';
        $page->redirect_url = '/magazine';
        $page->published = true;

        $parent = GenericPage::where('title', 'Membership')->first();
        $page->parent_id = $parent->id;

        $page->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $page = GenericPage::where('title', 'Member Magazine')->first();

        if ($page) {
            $page->delete();
        }
    }
}
