<?php

use App\Models\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('youtube_id', length: 11)->nullable();
            $table->dateTime('uploaded_at')->nullable();
        });
        $this->populateVideoYouTubeId();

        Schema::create('playlists_videos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('playlist_id');
            $table->foreignId('video_id');
            $table->integer('position')->unsigned();
            $table->string('youtube_id')->unique();
            $table->index(['playlist_id', 'video_id', 'position']);
        });

        Schema::create('playlists', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title');
            $table->string('youtube_id', length: 34)->unique();
        });
        $this->populatePlaylistYouTubeId();

        $this->pruneNonVideoRecords();

        // All entries in the videos table should now have a youtube_id, and
        // this column should not be nullable.
        Schema::table('videos', function (Blueprint $table) {
            $table->string('youtube_id', length: 11)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('playlists');

        Schema::dropIfExists('playlists_videos');

        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['youtube_id', 'uploaded_at']);
        });
    }


    // Move playlist data in the video table to the playlist table.
    private function populatePlaylistYouTubeId()
    {
        $withPlaylistUrl = Video::whereLike('video_url', 'https://www.youtube.com/playlist?list=%');
        foreach ($withPlaylistUrl->get() as $playlist) {
            $query = parse_url($playlist->video_url, PHP_URL_QUERY);
            parse_str($query, $params);
            $playlistId = $params['list'];
            DB::table('playlists')->insert([
                'title' => $playlist->title,
                'youtube_id' => $playlistId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $playlist->forceDelete();
        }
    }

    // Set the video_id column by parsing it out of the video_url column.
    private function populateVideoYouTubeId()
    {
        $withFullUrl = Video::whereLike('video_url', 'https://www.youtube.com/watch?v=%');
        foreach ($withFullUrl->get() as $video) {
            $query = parse_url($video->video_url, PHP_URL_QUERY);
            parse_str($query, $params);
            $videoId = $params['v'];
            $video->youtube_id = $videoId;
            $video->save();
        }

        $withShortenedUrl = Video::whereLike('video_url', 'https://youtu.be/%');
        foreach ($withShortenedUrl->get() as $video) {
            $path = str(parse_url($video->video_url, PHP_URL_PATH));
            $videoId = $path->trim('/');
            $video->youtube_id = $videoId;
            $video->save();
        }

        $withShortsUrl = Video::whereLike('video_url', 'https://www.youtube.com/shorts/%');
        foreach ($withShortsUrl->get() as $video) {
            $path = str(parse_url($video->video_url, PHP_URL_PATH));
            $videoId = $path->afterLast('/');
            $video->youtube_id = $videoId;
            $video->save();
        }
    }

    // Remove profile entry and deleted records from the videos table.
    private function pruneNonVideoRecords()
    {
        Video::whereLike('video_url', 'https://www.youtube.com/user/%')->forceDelete();

        Video::onlyTrashed()->forceDelete();
    }
};
