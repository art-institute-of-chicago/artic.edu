<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\NestedData;
use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Filters\BasicFilter;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\Filters\TableFilters;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Playlist;
use App\Models\Video;
use App\Repositories\CategoryRepository;
use App\Twill\Services\Listings\Columns\ImageWithFallback;
use Illuminate\Contracts\Database\Eloquent\Builder;

class VideoController extends BaseController
{
    protected function setUpController(): void
    {
        $this->enableShowImage();

        $this->eagerLoadListingRelations(['captions', 'playlists']);

        $this->setModuleName('videos');
        $this->setPreviewView('site.videoDetail');
        $this->setSearchColumns(['title', 'youtube_id']);
    }

    public function filters(): TableFilters
    {
        return TableFilters::make([
            BasicFilter::make()
                ->queryString('playlists')
                ->options(Playlist::orderBy('title')->pluck('title', 'id'))
                ->apply(function (Builder $builder, string $playlistId) {
                    $builder->whereHas('playlists', function (Builder $builder) use ($playlistId) {
                        $builder->where('playlists.id', $playlistId);
                    });
                }),
        ]);
    }

    public function quickFilters(): QuickFilters
    {
        $filters = parent::quickFilters();
        $afterSecondFilter = $filters->splice(2);
        $filters->add(
            QuickFilter::make()
                ->queryString('is_short')
                ->label('Shorts')
                ->amount(fn () => $this->repository->where('is_short', true)->count())
                ->apply(fn (Builder $builder) => $builder->where('is_short', true))
        );
        $filters->add(
            QuickFilter::make()
                ->queryString('is_uploaded')
                ->label('Uploaded')
                ->amount(fn () => $this->repository->whereNotNull('uploaded_at')->count())
                ->apply(fn (Builder $builder) => $builder->whereNotNull('uploaded_at'))
        );

        return $filters->merge($afterSecondFilter);
    }

    protected function getIndexTableColumns(): TableColumns
    {
        $columns = parent::getIndexTableColumns();
        if ($this->indexOptions['showImage']) {
            // Replace default thumbnail Image column with ImageWithFallback
            $afterFirstColumn = $columns->splice(1);
            $afterFirstColumn->shift(); // Remove Image column
            // Replace it with ImageWithFallback column
            $columns->push(
                ImageWithFallback::make()
                    ->field('thumbnail')
                    ->title('Thumbnail')
                    ->fallback(fn ($video) => $video->thumbnail_url)
            );

            return $columns->merge($afterFirstColumn);
        }

        return $columns;
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
                ->field('format')
                ->title('Format')
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
            NestedData::make()
                ->field('captions')
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

    protected function getBrowserTableColumns(): TableColumns
    {
        $columns = parent::getBrowserTableColumns();
        if ($this->indexOptions['showImage']) {
            $afterFirstColumn = $columns->splice(1);
            $afterFirstColumn->shift(); // Remove Image column
            // Replace it with ImageWithFallback column
            $columns = new TableColumns();
            $columns->push(
                ImageWithFallback::make()
                    ->field('thumbnail')
                    ->title('Thumbnail')
                    ->fallback(fn ($video) => $video->thumbnail_url)
            );

            return $columns->merge($afterFirstColumn);
        }

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
