<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Breadcrumbs\NestedBreadcrumbs;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Repositories\VideoRepository;

class VideoCaptionController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disableBulkDelete();
        $this->disableBulkEdit();
        $this->disableBulkForceDelete();
        $this->disableBulkRestore();
        $this->disableCreate();
        $this->disableDelete();
        $this->disableForceDelete();
        $this->disableRestore();

        $this->eagerLoadListingRelations(['video']);

        $this->setModelName('Caption');
        $this->setModuleName('videos.captions');

        $this->setBreadcrumbs(NestedBreadcrumbs::make()
            ->forParent(
                parentModule: 'videos',
                module: $this->moduleName,
                activeParentId: request('video'),
                repository: VideoRepository::class,
                routePrefix: 'collection.articlesPublications',
            )
            ->label('Captions'));
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->field('updated_at')
                ->sortable()
        );
        $columns->add(
            Text::make()
                ->field('kind')
                ->sortable()
        );
        $columns->add(
            Text::make()
                ->field('name')
                ->sortable()
                ->optional()
                ->hide()
        );
        $columns->add(
            Text::make()
                ->field('youtube_id')
                ->title('YouTube ID')
                ->optional()
                ->hide()
        );

        return $columns;
    }
}
