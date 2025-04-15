<?php

namespace App\Repositories\Behaviors;

use A17\Twill\Models\Contracts\TwillModelContract;

trait HandleAuthors
{
    public function afterSaveHandleAuthors(TwillModelContract $object, array $fields): void
    {
        $this->updateBrowser($object, $fields, 'authors');
    }

    public function getFormFieldsHandleAuthors(TwillModelContract $object, array $fields): array
    {
        $fields['browsers']['authors'] = $this->getFormFieldsForBrowser($object, 'authors', 'collection');

        return $fields;
    }
}
