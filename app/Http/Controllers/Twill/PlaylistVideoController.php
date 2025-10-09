<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Breadcrumbs\NestedBreadcrumbs;
use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\PlaylistVideo;
use App\Models\Video;
use App\Twill\Services\Listings\Columns\ImageWithFallback;

class PlaylistVideoController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disableBulkDelete();
        $this->disableBulkEdit();
        $this->disableBulkForceDelete();
        $this->disableBulkPublish();
        $this->disableBulkRestore();
        $this->disableCreate();
        $this->disableDelete();
        $this->disableEdit();
        $this->disableForceDelete();
        $this->disablePublish();
        $this->disableRestore();

        $this->setModelName('PlaylistVideo');
        $this->setModuleName('playlists.videos');
        $this->setTitleColumnKey('position');
        $this->setTitleColumnLabel('Position');

        $this->setBreadcrumbs(NestedBreadcrumbs::make()
            ->forParent(
                parentModule: 'playlists',
                module: $this->moduleName,
                activeParentId: request('playlist'),
                repository: \App\Repositories\PlaylistRepository::class,
                routePrefix: 'collection.articlesPublications',
            )
            ->label('Videos'));
    }

    public function quickFilters(): QuickFilters
    {
        $scope = ($this->submodule ? [
            $this->getParentModuleForeignKey() => $this->submoduleParentId,
        ] : []);

        return QuickFilters::make([
            QuickFilter::make()
                ->label(twillTrans('twill::lang.listing.filter.all-items'))
                ->queryString('all')
                ->amount(fn () => $this->repository->getCountByStatusSlug('all', $scope)),
        ]);
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            ImageWithFallback::make()
                ->field('thumbnail')
                ->title('Thumbnail')
                ->fallback(fn (PlaylistVideo $playlistVideo) => $playlistVideo->video->thumbnail_url)
        );
        $columns->add(
            Relation::make()
                ->relation('video')
                ->field('title')
                ->title('Title')
                ->linkCell(function (PlaylistVideo $playlistVideo) {
                    return route('twill.collection.articlesPublications.videos.edit', [
                        'video' => $playlistVideo->video->id,
                    ]);
                })
        );
        $columns->add(
            Relation::make()
                ->relation('video')
                ->field('duration')
        );
        $columns->add(
            Relation::make()
                ->relation('video')
                ->field('format')
        );
        $columns->add(
            Text::make()
                ->field('uploaded_at')
                ->customRender(function (PlaylistVideo $playlistVideo) {
                    return $playlistVideo->video->uploaded_at?->format('M j, Y');
                })
        );
        $columns->add(
            Text::make()
                ->field('youtube_id')
                ->title('YouTube ID')
                ->hide()
                ->optional()
                ->linkCell(fn (PlaylistVideo $playlistVideo) => $playlistVideo->sourceUrl)
        );

        return $columns;
    }
}
