<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository as BaseModuleRepository;

class ModuleRepository extends BaseModuleRepository
{
    /**
     * Remove trailing newlines from WYSIWYG fields
     */
    public function prepareFieldsBeforeSave($object, $fields)
    {

        // Fields
        foreach ($fields as $key => $field) {
            $fields[$key] = rightTrim($field, '<p><br></p>');
        }

        // Block content
        foreach ($fields['blocks'] as $blockKey => $block) {
            foreach ($block['content'] as $contentKey => $content) {
                $fields['blocks'][$blockKey]['content'][$contentKey] = rightTrim($content, '<p><br></p>');
            }
        }

        return parent::prepareFieldsBeforeSave($object, $fields);
    }
}
