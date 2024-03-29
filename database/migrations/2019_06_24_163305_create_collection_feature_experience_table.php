<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->down();

        Schema::create('collection_feature_experience', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('experience_id')->unsigned();
            $table->foreign('experience_id')->references('id')->on('experiences')->onDelete('cascade');
            $table->integer('collection_feature_id')->unsigned();
            $table->foreign('collection_feature_id')->references('id')->on('collection_features')->onDelete('cascade');
            $table->index(['collection_feature_id', 'experience_id'], 'collection_feature_experience_idx');

            $table->integer('position')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_feature_experience');
    }
};
