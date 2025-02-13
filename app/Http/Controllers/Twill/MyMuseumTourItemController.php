<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class MyMuseumTourItemController extends BaseController
{
    public function setUpController(): void
    {
        parent::setUpController();
        $this->enableShowImage();
        $this->setModuleName('myMuseumTourItems');
        $this->setSearchColumns(['title', 'teaser_text', 'tour_id']);
    }

    public function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->field('teaser_text')
        );
        $columns->add(
            Text::make()
                ->field('artwork_count')
                ->optional()
                ->hide()
        );
        $columns->add(
            Text::make()
                ->field('tour_id')
                ->sortable()
                ->optional()
                ->hide()
        );

        return $columns;
    }
}
