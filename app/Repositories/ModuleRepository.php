<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository as BaseModuleRepository;
use A17\Twill\Repositories\Behaviors\HandleRelatedBrowsers;

use App\Repositories\Behaviors\HandleApiBrowsers;
use App\Helpers\StringHelpers;

abstract class ModuleRepository extends BaseModuleRepository
{
    use HandleRelatedBrowsers, HandleApiBrowsers;

    /**
     * Remove trailing newlines from WYSIWYG fields
     */
    public function prepareFieldsBeforeSave($object, $fields)
    {

        // Fields
        foreach ($fields as $key => $field) {
            $fields[$key] = StringHelpers::rightTrim($field, '<p><br></p>');
        }

        // Block content (for `HasBlocks` only)
        if (isset($fields['blocks'])) {
            foreach ($fields['blocks'] as $blockKey => $block) {
                foreach ($block['content'] as $contentKey => $content) {
                    $fields['blocks'][$blockKey]['content'][$contentKey] = StringHelpers::rightTrim($content, '<p><br></p>');
                }
            }
        }

        return parent::prepareFieldsBeforeSave($object, $fields);
    }
}
