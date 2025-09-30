<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\NestedData;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Playlist;
use App\Twill\Services\Listings\Columns\ImageWithFallback;

class PlaylistController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disableCreate();
        $this->disableDelete();

        $this->eagerLoadListingRelations(['videos']);

        $this->enableShowImage();

        $this->setModuleName('playlists');
        $this->setSearchColumns(['title', 'youtube_id']);
    }

    protected function getIndexTableColumns(): TableColumns
    {
        $columns = parent::getIndexTableColumns();
        if ($this->indexOptions['showImage']) {
            $afterFirstColumn = $columns->splice(1);
            $afterFirstColumn->shift(); // Remove Image column
            // Replace it with ImageWithFallback column
            $columns->push(
                ImageWithFallback::make()
                    ->field('thumbnail')
                    ->title('Thumbnail')
                    ->fallback(fn (Playlist $playlist) => $playlist->thumbnail_url)
            );

            return $columns->merge($afterFirstColumn);
        }

        return $columns;
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            NestedData::make()
                ->field('videos')
        );
        $columns->add(
            Text::make()
                ->field('youtube_id')
                ->title('YouTube ID')
                ->optional()
                ->hide()
                ->linkCell(fn (Playlist $playlist) => $playlist->source_url)
        );

        return $columns;
    }

    protected function getBrowserTableColumns(): TableColumns
    {
        $columns = parent::getBrowserTableColumns();
        if ($this->indexOptions['showImage']) {
            $afterFirstColumn = $columns->splice(1);
            $afterFirstColumn->shift(); // Remove Image column
            // Replace it with ImageWithFallback column
            $columns->push(
                ImageWithFallback::make()
                    ->field('thumbnail')
                    ->title('Thumbnail')
                    ->fallback(fn (Playlist $playlist) => $playlist->thumbnail_url)
            );

            return $columns->merge($afterFirstColumn);
        }

        return $columns;
    }
}
