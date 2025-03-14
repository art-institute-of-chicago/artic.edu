<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class VanityRedirectController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->enableEditInModal();
        $this->setModuleName('vanityRedirects');
        $this->setTitleColumnKey('path');
        $this->setTitleColumnLabel('Vanity path');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->field('destination')
        );

        return $columns;
    }
}
