<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSelectionsToHighlights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rename tables
        Schema::rename('selections', 'highlights');
        Schema::rename('selection_slugs', 'highlight_slugs');
        Schema::rename('selection_revisions', 'highlight_revisions');
        Schema::rename('home_feature_selection', 'highlight_home_feature');

        // Rename columns
        Schema::table('highlight_slugs', function (Blueprint $table) {
            $table->renameColumn('selection_id', 'highlight_id');
        });

        Schema::table('highlight_revisions', function (Blueprint $table) {
            $table->renameColumn('selection_id', 'highlight_id');
        });

        Schema::table('highlight_home_feature', function (Blueprint $table) {
            $table->renameColumn('selection_id', 'highlight_id');
        });

        // Rename morph map values
        DB::update(
            'update api_relatables set '
            . 'api_relatable_type = ? '
            . 'where api_relatable_type = ?',
            ['highlights',
                'selections']
        );

        DB::update(
            'update mediables set '
            . 'mediable_type = ? '
            . 'where mediable_type = ?',
            ['highlights',
                'selections']
        );

        DB::update(
            'update blocks set '
            . 'blockable_type = ? '
            . 'where blockable_type = ?',
            ['highlights',
                'selections']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rename tables
        Schema::rename('highlights', 'selections');
        Schema::rename('highlight_slugs', 'selection_slugs');
        Schema::rename('highlight_revisions', 'selection_revisions');
        Schema::rename('highlight_home_feature', 'home_feature_selection');

        // Rename columns
        Schema::table('selection_slugs', function (Blueprint $table) {
            $table->renameColumn('highlight_id', 'selection_id');
        });

        Schema::table('selection_revisions', function (Blueprint $table) {
            $table->renameColumn('highlight_id', 'selection_id');
        });

        Schema::table('home_feature_selection', function (Blueprint $table) {
            $table->renameColumn('highlight_id', 'selection_id');
        });

        // Rename morph map values
        DB::update(
            'update api_relatables set '
            . 'api_relatable_type = ? '
            . 'where api_relatable_type = ?',
            ['selections',
                'highlights']
        );

        DB::update(
            'update mediables set '
            . 'mediable_type = ? '
            . 'where mediable_type = ?',
            ['selections',
                'highlights']
        );

        DB::update(
            'update blocks set '
            . 'blockable_type = ? '
            . 'where blockable_type = ?',
            ['selections',
                'highlights']
        );
    }
}
