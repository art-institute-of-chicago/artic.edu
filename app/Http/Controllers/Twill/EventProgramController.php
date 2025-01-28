<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\TableColumns;

class EventProgramController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->disablePublish();
        $this->enableEditInModal();
        $this->setModuleName('eventPrograms');
        $this->setTitleColumnKey('name');
        $this->setTitleColumnLabel('Name');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Presenter::make()
                ->field('isAffiliateGroup')
                ->title('Affiliate Group?')
                ->optional()
        );
        $columns->add(
            Presenter::make()
                ->field('isEventHost')
                ->title('Event Host?')
                ->optional()
        );

        return $columns;
    }
}
