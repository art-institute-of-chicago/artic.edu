<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Cartalyst\Tags\IlluminateTag;

class AddRestrictDownloadTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tag = new IlluminateTag;
        $tag->name = 'Restrict Download';
        $tag->slug = 'restrict-download';
        $tag->namespace = 'media';
        $tag->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tag = IlluminateTag::where('slug', 'restrict-download')->first();
        $tag->delete();
    }
}
