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

        // Block content (for `HasBlocks` only)
        if (isset($fields['blocks'])) {
            foreach ($fields['blocks'] as $blockKey => $block) {
                foreach ($block['content'] as $contentKey => $content) {
                    $fields['blocks'][$blockKey]['content'][$contentKey] = rightTrim($content, '<p><br></p>');
                }
            }
        }

        return parent::prepareFieldsBeforeSave($object, $fields);
    }

    /**
     * Overrides and calls \A17\Twill\Repositories\ModuleRepository::afterSave()
     * Touch object after updating its relationships to bump its timestamps for API.
     * Note that we are calling `save()` on the model, not `update()` on the module,
     * so this shouldn't cause an infinite loop.
     */
    public function afterSave($object, $fields)
    {
        parent::afterSave($object, $fields);

        $object->touch();
    }

}
