<?php

namespace App\Models;

use A17\Twill\Models\Media;
use Illuminate\Support\Facades\DB;

class PublicationMedia extends Media
{
    public function scopeUnused ($query)
    {
        $usedIds = DB::table(config('twill.publication_mediables_table'))->get()->pluck('publication_media_id');
        return $query->whereNotIn('id', $usedIds->toArray())->get();
    }

    public function canDeleteSafely()
    {
        return DB::table(config('twill.publication_mediables_table', 'publication_mediables'))->where('publication_media_id', $this->id)->count() === 0;
    }

    public function isReferenced()
    {
        return DB::table(config('twill.publication_mediables_table', 'publication_mediables'))->where('publication_media_id', $this->id)->count() > 0;
    }

    public function toCmsArray()
    {
        $ret = parent::toCmsArray();

        $ret['deleteUrl'] = $this->canDeleteSafely() ? route('admin.media-library.publication-medias.single-update', $this->id) : null;
        $ret['updateUrl'] = route('admin.media-library.publication-medias.single-update');
        $ret['updateBulkUrl'] = route('admin.media-library.publication-medias.bulk-update');
        $ret['deleteBulkUrl'] = route('admin.media-library.publication-medias.bulk-delete');

        return $ret;
    }

    public function replace($fields)
    {
        $prevHeight = $this->height;
        $prevWidth = $this->width;

        if ($this->update($fields) && $this->isReferenced())
        {
            DB::table(config('twill.publication_mediables_table', 'publication_mediables'))->where('publication_media_id', $this->id)->get()->each(function ($mediable) use ($prevWidth, $prevHeight) {

                if ($prevWidth != $this->width) {
                    $mediable->crop_x = 0;
                    $mediable->crop_w = $this->width;
                }

                if ($prevHeight != $this->height) {
                    $mediable->crop_y = 0;
                    $mediable->crop_h = $this->height;
                }

                DB::table(config('twill.publication_mediables_table', 'publication_mediables'))->where('id', $mediable->id)->update((array)$mediable);
            });
        }
    }

    public function getTable()
    {
        return config('twill.publication_medias_table', 'publication_medias');
    }
}
