<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_features', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true);
            $table->string('title')->nullable();
        });

        Schema::create('article_collection_feature', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer("article_id")->unsigned();
            $table->foreign("article_id")->references('id')->on('articles')->onDelete('cascade');
            $table->integer("collection_feature_id")->unsigned();
            $table->foreign("collection_feature_id")->references('id')->on('collection_features')->onDelete('cascade');
            $table->index(["collection_feature_id", "article_id"], 'article_collection_feature_collection_feature_id_article_id_idx');

            $table->integer('position')->unsigned()->index();
        });

        Schema::create('collection_feature_selection', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer("selection_id")->unsigned();
            $table->foreign("selection_id")->references('id')->on('selections')->onDelete('cascade');
            $table->integer("collection_feature_id")->unsigned();
            $table->foreign("collection_feature_id")->references('id')->on('collection_features')->onDelete('cascade');
            $table->index(["collection_feature_id", "selection_id"], 'sel_collection_feature_collection_feature_id_sel_id_idx');
            $table->integer('position')->unsigned()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collection_feature_selection');
        Schema::dropIfExists('article_collection_feature');
        Schema::dropIfExists('collection_features');
    }
}
