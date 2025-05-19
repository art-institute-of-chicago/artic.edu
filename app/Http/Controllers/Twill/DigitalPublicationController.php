<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\NestedData;
use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\TableColumns;
use App\Repositories\CatalogCategoryRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class DigitalPublicationController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->setModuleName('digitalPublications');
        $this->setPreviewView('site.genericPage.show');
    }

    public function quickFilters(): QuickFilters
    {
        $filters = parent::quickFilters();
        $afterThirdFilter = $filters->splice(3);
        $filters->add(
            QuickFilter::make()
                ->queryString('is_unlisted')
                ->label('Unlisted')
                ->amount(fn() => $this->repository->where('is_unlisted', true)->count())
                ->apply(fn(Builder $builder) => $builder->where('is_unlisted', true))
        );

        return $filters->merge($afterThirdFilter);
    }

    protected function getIndexTableColumns(): TableColumns
    {

        $columns = parent::getIndexTableColumns();
        $afterFirstColumn = $columns->splice(1);
        $columns->push(
            Text::make()
                ->field('is_unlisted')
                ->title('Listed/Unlisted')
                ->sortable()
                ->optional()
                ->hide()
                ->customRender(fn ($digitalPublication) => $digitalPublication->is_unlisted ? 'Unlisted' : 'Listed')
        );

        return $columns->merge($afterFirstColumn);
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Presenter::make()
                ->field('is_dsc_stub')
                ->title('Is DSC stub?')
                ->sortable()
        );
        $columns->add(
            NestedData::make()
                ->field('articles')
        );

        return $columns;
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('digitalPublication') ?? request('id'));
        $baseUrl = config('app.url') . '/digital-publications/' . $item->id . '/';
        $heroBackgroundColors = collect(config('aic.branding.colors.digital_publications'))
            ->mapWithKeys(fn ($hexColor) => [$hexColor => $hexColor]);

        return [
            'categoriesList' => app(CatalogCategoryRepository::class)->listAll('name'),
            'baseUrl' => $baseUrl,
            'heroBackgroundColors' => $heroBackgroundColors,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}
