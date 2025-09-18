<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Video;
use App\Repositories\CategoryRepository;

class VideoController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disableCreate();
        $this->setModuleName('videos');
        $this->setPreviewView('site.videoDetail');
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
                ->customRender(fn (Video $video) => "<img style='max-width: 80px' src='$video->thumbnail_url' />")
        );

        return $columns->merge($afterFirstColumn);
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->field('duration')
        );
        $columns->add(
            Text::make()
                ->field('uploaded_at')
                ->sortable()
                ->customRender(fn (Video $video) => (string) $video->uploaded_at?->format('M j, Y'))
        );
        $columns->add(
            Relation::make()
                ->relation('playlists')
                ->field('title')
                ->title('Playlists')
                ->optional()
        );
        $columns->add(
            Text::make()
                ->field('youtube_id')
                ->title('YouTube ID')
                ->optional()
                ->hide()
                ->linkCell(fn (Video $video) => $video->source_url)
        );

        return $columns;
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('video') ?? request('id'));
        $baseUrl = config('app.url') . '/videos/' . $item->id . '-';

        return [
            'baseUrl' => $baseUrl,
            'categoriesList' => app(CategoryRepository::class)->listAll('name'),
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
