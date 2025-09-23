<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use App\Models\Behaviors\HasMedias;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlaylistVideo extends AbstractModel implements Sortable
{
    use HasMedias;
    use HasPosition;

    protected $table = 'playlist_video';

    protected $fillable = [
        'position',
        'youtube_id',
    ];

    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class);
    }

    public function sourceUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $videoId = $this->video->youtube_id;
                $playlistid = $this->playlist->youtube_id;
                return "https://youtube.com/watch?v=$videoId&list=$playlistid";
            }
        );
    }
}
