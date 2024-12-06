<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleRelatedBrowsers;
use A17\Twill\Repositories\ModuleRepository as BaseModuleRepository;
use App\Helpers\StringHelpers;
use App\Repositories\Behaviors\HandleApiBrowsers;
use Illuminate\Database\Eloquent\Casts\AsCollection;

abstract class ModuleRepository extends BaseModuleRepository
{
    use HandleRelatedBrowsers;
    use HandleApiBrowsers;

    /**
     * Flatten attributes cast as collections to fields with dot-separated field
     * names.
     */
    public function getFormFields(\A17\Twill\Models\Contracts\TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);
        $collectionFieldNames = collect($object->casts)->filter(fn ($cast) => $cast === AsCollection::class)->keys();
        foreach ($collectionFieldNames as $fieldName) {
            $field = $fields[$fieldName] ?? [];
            foreach ($field as $key => $value) {
                $fields["$fieldName.$key"] = $value;
            }
            unset($fields[$fieldName]);
        }

        return $fields;
    }

    /**
     * Remove trailing newlines from WYSIWYG fields and transform fields with dot-
     * separated names into arrays.
     */
    public function prepareFieldsBeforeSave(\A17\Twill\Models\Contracts\TwillModelContract $object, array $fields): array
    {
        // Remove trailing newlines from fields
        foreach ($fields as $key => $field) {
            $fields[$key] = StringHelpers::rightTrim($field, '<p><br class="softbreak"></p>');
        }

        // Remove trailing newlines from block content (for `HasBlocks` only)
        if (isset($fields['blocks'])) {
            foreach ($fields['blocks'] as $blockKey => $block) {
                foreach ($block['content'] as $contentKey => $content) {
                    $fields['blocks'][$blockKey]['content'][$contentKey] =
                        StringHelpers::rightTrim($content, '<p><br class="softbreak"></p>');
                }
            }
        }

        // Transform dot-separated fields
        foreach ($fields as $key => $value) {
            $key = str($key);
            if ($key->contains('.') && !is_null($value)) {
                [$fieldKey, $jsonKey] = $key->explode('.', 2);
                $fields[$fieldKey][$jsonKey] = $value;
                unset($fields[(string) $key]);
            }
        }

        return parent::prepareFieldsBeforeSave($object, $fields);
    }
}
