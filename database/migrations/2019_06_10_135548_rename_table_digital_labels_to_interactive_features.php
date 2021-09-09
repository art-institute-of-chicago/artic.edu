<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTableDigitalLabelsToInteractiveFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('digital_labels', 'interactive_features');
        Schema::rename('digital_label_slugs', 'interactive_feature_slugs');
        Schema::rename('digital_label_revisions', 'interactive_feature_revisions');
        Schema::table('interactive_feature_slugs', function (Blueprint $table) {
            $table->renameColumn('digital_label_id', 'interactive_feature_id');
        });
        Schema::table('interactive_feature_revisions', function (Blueprint $table) {
            $table->renameColumn('digital_label_id', 'interactive_feature_id');
        });
        Schema::table('experiences', function (Blueprint $table) {
            $table->renameColumn('digital_label_id', 'interactive_feature_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('interactive_features', 'digital_labels');
        Schema::rename('interactive_feature_slugs', 'digital_label_slugs');
        Schema::rename('interactive_feature_revisions', 'digital_label_revisions');
        Schema::table('interactive_feature_slugs', function (Blueprint $table) {
            $table->renameColumn('interactive_feature_id', 'digital_label_id');
        });
        Schema::table('interactive_feature_revisions', function (Blueprint $table) {
            $table->renameColumn('interactive_feature_id', 'digital_label_id');
        });
        Schema::table('experiences', function (Blueprint $table) {
            $table->renameColumn('interactive_feature_id', 'digital_label_id');
        });
    }
}
