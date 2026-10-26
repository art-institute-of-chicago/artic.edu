<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->string('related_content_title')->nullable();
            $table->text('related_content_description')->nullable();
            $table->boolean('override_related_content_title')->default(false);
            $table->string('publications_title')->nullable();
            $table->text('publications_description')->nullable();
            $table->boolean('override_publications_title')->default(false);
            $table->string('exhibitions_title')->nullable();
            $table->text('exhibitions_description')->nullable();
            $table->boolean('override_exhibitions_title')->default(false);
            $table->string('educator_resources_title')->nullable();
            $table->text('educator_resources_description')->nullable();
            $table->boolean('override_educator_resources_title')->default(false);
            $table->string('interactive_feature_title')->nullable();
            $table->text('interactive_feature_description')->nullable();
            $table->boolean('override_interactive_feature_title')->default(false);
            $table->string('digital_explorer_title')->nullable();
            $table->text('digital_explorer_description')->nullable();
            $table->boolean('override_digital_explorer_title')->default(false);
            $table->string('layered_image_viewer_title')->nullable();
            $table->text('layered_image_viewer_description')->nullable();
            $table->boolean('override_layered_image_viewer_title')->default(false);
            $table->string('videos_title')->nullable();
            $table->text('videos_description')->nullable();
            $table->boolean('override_videos_title')->default(false);
            $table->string('view_360_title')->nullable();
            $table->text('view_360_description')->nullable();
            $table->boolean('override_view_360_title')->default(false);
            $table->string('view_3d_title')->nullable();
            $table->text('view_3d_description')->nullable();
            $table->boolean('override_view_3d_title')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn([
                'related_content_title',
                'related_content_description',
                'override_related_content_title',
                'publications_title',
                'publications_description',
                'override_publications_title',
                'exhibitions_title',
                'exhibitions_description',
                'override_exhibitions_title',
                'educator_resources_title',
                'educator_resources_description',
                'override_educator_resources_title',
                'interactive_feature_title',
                'interactive_feature_description',
                'override_interactive_feature_title',
                'digital_explorer_title',
                'digital_explorer_description',
                'override_digital_explorer_title',
                'layered_image_viewer_title',
                'layered_image_viewer_description',
                'override_layered_image_viewer_title',
                'videos_title',
                'videos_description',
                'override_videos_title',
                'view_360_title',
                'view_360_description',
                'override_view_360_title',
                'view_3d_title',
                'view_3d_description',
                'override_view_3d_title',
            ]);
        });
    }
};
