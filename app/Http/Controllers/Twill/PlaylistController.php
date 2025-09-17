<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Playlist;

class PlaylistController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disableCreate();
        $this->disableDelete();
        $this->disablePermalink();
        $this->setModuleName('playlists');
        $this->setSearchColumns(['title', 'youtube_id']);
    }

    protected function getIndexTableColumns(): TableColumns
    {
        $columns = parent::getIndexTableColumns();
        $afterFirstColumn = $columns->splice(1);
        $columns->push(
            Text::make()
                ->field('thumbnail_url')
                ->title(null)
                ->renderHtml()
                ->customRender(fn (Playlist $playlist) => "<img style='max-width: 80px' src='$playlist->thumbnail_url' />")
        );

        return $columns->merge($afterFirstColumn);
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Relation::make()
                ->relation('videos')
                ->field('title')
                ->title('Videos')
                ->optional()
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
}
