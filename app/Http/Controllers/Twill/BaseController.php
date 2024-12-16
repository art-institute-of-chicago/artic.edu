<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;

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
}
