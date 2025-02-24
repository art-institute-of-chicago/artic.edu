<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;

class BaseController extends ModuleController
{
    protected function setUpController(): void
    {
        $this->enableSkipCreateModal();
    }

    public function edit(TwillModelContract|int $id): mixed
    {
        $view = parent::edit($id);
        if (!$this->getIndexOption('editInModal')) {
            $view = $view->with([
                'editableTitle' =>
                    $this->repository->isFillable($this->titleColumnKey)
                    || $this->repository->isTranslatable($this->titleColumnKey),
            ]);
        }
        return $view;
    }
}
