<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\Columns\Relation;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\AdCampaign;

class AdCampaignController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disableIncludeScheduledInList();
        $this->disablePermalink();
        $this->enableReorder();
        $this->enableShowImage();
        $this->setModuleName('adCampaigns');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = parent::additionalIndexTableColumns();
        $columns->add(
            Text::make()
                ->field('header')
                ->title('Header')
                ->optional()
                ->hide()
        );
        $columns->add(
            Text::make()
                ->field('description')
                ->title('Description')
                ->optional()
                ->hide()
        );
        $columns->add(
            Text::make()
                ->field('destination_label')
                ->title('Destination Label')
                ->optional()
                ->hide()
        );
        $columns->add(
            Text::make()
                ->field('destination_url')
                ->title('Destination URL')
                ->optional()
                ->hide()
        );
        $columns->add(
            Relation::make()
                ->relation('artists')
                ->field('datahub_id')
                ->title('Artist')
                ->optional()
                ->hide()
        );
        $columns->add(
            Relation::make()
                ->relation('artworks')
                ->field('datahub_id')
                ->title('Artworks')
                ->optional()
                ->hide()
        );
        $columns->add(
            Text::make()
                ->field('start_date')
                ->title('Start Date')
                ->customRender(function (AdCampaign $adCampaign): string {
                    return $adCampaign->start_date?->format('M j, Y') ?? '--';
                })
        );
        $columns->add(
            Text::make()
                ->field('end_date')
                ->title('End Date')
                ->customRender(function (AdCampaign $adCampaign): string {
                    return $adCampaign->end_date?->format('M j, Y') ?? '--';
                })
        );

        return $columns;
    }
}
