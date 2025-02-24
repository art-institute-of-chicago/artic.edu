<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\NestedData;
use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\Filters\QuickFilter;
use A17\Twill\Services\Listings\Filters\QuickFilters;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\InteractiveFeature;
use App\Models\Article;
use App\Repositories\CategoryRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ExperienceController extends BaseController
{
    protected function setUpController(): void
    {
        $this->enableReorder();
        $this->enableShowImage();
        $this->setModelName('Experience');
        $this->setModuleName('experiences');
        $this->setPreviewView('site.experienceDetail');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Presenter::make()
                ->field('isWebPublished')
                ->title('Is web published?')
        );
        $columns->add(
            Relation::make()
                ->relation('interactiveFeature')
                ->field('title')
                ->title('Grouping')
        );
        $columns->add(
            NestedData::make()
                ->field('slides')
        );

        return $columns;
    }

    public function quickFilters(): QuickFilters
    {
        $filters = parent::quickFilters();
        $filters->add(
            QuickFilter::make()
            ->queryString('archived')
            ->label('Archived')
            ->amount(fn () => $this->repository->archived()->count())
            ->apply(fn (Builder $query) => $query->archived())
        );

        return $filters;
    }

    public function getPermalinkBaseUrl()
    {
        return config('app.url') . '/interactive-features/';
    }

    protected function previewData($item)
    {
        $articles = Article::published()
            ->orderBy('date', 'desc')
            ->notUnlisted()
            ->paginate(4);

        return [
            'experience' => $item,
            'singleSlide' => true,
            'contrastHeader' => true,
            'slide' => $item,
            'furtherReading' => $articles,
            'canonicalUrl' => route('interactiveFeatures.show', ['id' => $item->id, 'slug' => $item->titleSlug]),
        ];
    }

    protected function formData($request)
    {
        return [
            'categoriesList' => app(CategoryRepository::class)->listAll('name'),
            'groupingsList' => InteractiveFeature::all()->pluck('title', 'id')
        ];
    }

    protected function getBrowserTableData($items, bool $forRepeater = false): array
    {
        $withImage = $this->moduleHas('medias');

        return $items->map(function ($item) use ($withImage) {
            $columnsData = collect($this->browserColumns)->mapWithKeys(function ($column) use ($item) {
                return $this->getItemColumnData($item, $column);
            })->toArray();

            $name = $columnsData[$this->titleColumnKey];
            unset($columnsData[$this->titleColumnKey]);

            return [
                'id' => $item->id,
                'name' => $name,
                'edit' => '',
                'endpointType' => $this->moduleName,
            ] + $columnsData + ($withImage && !array_key_exists('thumbnail', $columnsData) ? [
                'thumbnail' => $item->defaultCmsImage(['w' => 100, 'h' => 100]),
            ] : []);
        })->toArray();
    }

    protected function getBrowserData($prependScope = []): array
    {
        if (request()->has('except')) {
            $prependScope['exceptIds'] = request('except');
        }

        $scopes = $this->filterScope($prependScope);
        $items = $this->getBrowserItems($scopes);
        $data = $this->getBrowserTableData($items);

        return array_replace_recursive(['data' => $data], []);
    }
}
