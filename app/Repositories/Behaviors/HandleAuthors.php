<?php

namespace App\Repositories\Behaviors;

trait HandleAuthors
{
    public function afterSaveHandleAuthors($object, $fields)
    {
        $this->updateBrowser($object, $fields, 'authors');
    }

    public function getFormFieldsHandleAuthors($object, $fields)
    {
        $fields['browsers']['authors'] = $this->getFormFieldsForBrowser($object, 'authors', 'collection');

        return $fields;
    }
}
