<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistBrowsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $articleArtists = DB::table('article_artist')->select('*')->get();

        foreach ($articleArtists as $article) {
            DB::table('related')->insert([
                'subject_id'    =>  $article->artist_id,
                'subject_type'  =>  'artists',
                'related_type'  =>  'articles',
                'related_id'    =>  $article->article_id,
                'browser_name'  =>  'related_items',
                'position'      =>  $article->position,
            ]);
        }

        Schema::dropIfExists('article_artist');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('article_artist', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'article', 'artist');
            $table->integer('position')->unsigned()->index();
        });
    }
}
