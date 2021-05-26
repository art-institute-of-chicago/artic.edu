<?php

namespace App\Repositories;

use BadMethodCallException;
use A17\Twill\Repositories\ModuleRepository as BaseModuleRepository;

use App\Repositories\Behaviors\HandleRelatedBrowsers;

abstract class ModuleRepository extends BaseModuleRepository
{
    use HandleRelatedBrowsers;

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
     * Temporary work-around for https://github.com/area17/twill/issues/723
     */
    public function safeForSlug($slug, $with = [], $withCount = [], $scopes = [])
    {
        try {
            return $this->forSlug(...func_get_args());
        } catch (BadMethodCallException $e) {
            abort(404);
        }
    }
}
