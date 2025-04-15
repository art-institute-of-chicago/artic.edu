<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Lightbox;

class LightboxController extends BaseController
{
    public function setUpController(): void
    {
        $this->setModuleName('lightboxes');
    }

    public function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->title('Start Date')
                ->field('lightbox_start_date')
                ->optional()
                ->sortable()
                ->customRender(function (Lightbox $lightbox): string {
                    return $lightbox?->lightbox_start_date->format('M j, Y') ?? '';
                })
        );
        $columns->add(
            Text::make()
                ->title('End Date')
                ->field('lightbox_end_date')
                ->optional()
                ->sortable()
                ->customRender(function (Lightbox $lightbox): string {
                    return $lightbox?->lightbox_end_date->format('M j, Y') ?? '';
                })
        );

        return $columns;
    }
}
