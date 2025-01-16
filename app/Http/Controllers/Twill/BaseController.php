<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\FeaturedStatus;
use A17\Twill\Services\Listings\Columns\Image;
use A17\Twill\Services\Listings\Columns\Languages;
use A17\Twill\Services\Listings\Columns\PublishStatus;
use A17\Twill\Services\Listings\Columns\ScheduledStatus;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class BaseController extends ModuleController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->enableSkipCreateModal();
    }

    public function edit(TwillModelContract|int $id): mixed
    {
        return parent::edit($id)->with([
            'editableTitle' =>
                $this->repository->isFillable($this->titleColumnKey)
                || $this->repository->isTranslatable($this->titleColumnKey),
        ]);
    }

    protected function getIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        if ($this->getIndexOption('publish')) {
            $columns->add(
                PublishStatus::make()
                    ->title(twillTrans('twill::lang.listing.columns.published'))
                    ->sortable()
                    ->optional()
            );
        }
        if ($this->getIndexOption('showImage')) {
            $columns->add(
                Image::make()
                    ->field('thumbnail')
                    ->title(twillTrans('Image'))
            );
        }
        if ($this->getIndexOption('feature') && $this->repository->isFillable('featured')) {
            $columns->add(
                FeaturedStatus::make()
                    ->title(twillTrans('twill::lang.listing.columns.featured'))
            );
        }

        $title = $this->titleColumnKey === 'title' && $this->titleColumnLabel === 'Title'
            ? twillTrans('twill::lang.main.title')
            : $this->titleColumnLabel;
        $columns->add(
            Text::make()
                ->field($this->titleColumnKey)
                ->title($title)
                ->sortable()
                ->linkToEdit()
        );
        $columns = $columns->merge($this->additionalIndexTableColumns());
        if ($this->getIndexOption('includeScheduledInList') && $this->repository->isFillable('publish_start_date')) {
            $columns->add(
                ScheduledStatus::make()
                    ->title(twillTrans('twill::lang.publisher.scheduled'))
                    ->optional()
            );
        }
        if ($this->moduleHas('translations') && count(getLocales()) > 1) {
            $columns->add(
                Languages::make()
                    ->title(twillTrans('twill::lang.listing.languages'))
                    ->optional()
            );
        }

        return $columns;
    }

    public function getSideFieldSets(TwillModelContract $model): Form
    {
        return parent::getSideFieldSets($model);
    }
}
