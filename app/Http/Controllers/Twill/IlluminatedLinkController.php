<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use Closure;

class IlluminatedLinkController extends BaseController
{
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->enableShowImage();
        $this->enableSkipCreateModal();
        $this->setModuleName('illuminatedLinks');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = parent::additionalIndexTableColumns();
        $columns->add(
            Text::make()
                ->field('url')
                ->title('URL')
                ->customRender(function (TwillModelContract $illuminatedLink) {
                    return "<a href='$illuminatedLink->url'>$illuminatedLink->url</a>";
                })
        );
        $columns->add(
            Text::make()
                ->field('description')
        );

        return $columns;
    }

    protected function additionalBrowserTableColumns(): TableColumns
    {
        $columns = parent::additionalBrowserTableColumns();
        $columns->add(
            Text::make()
                ->field('url')
        );
        return $columns;
    }
}
