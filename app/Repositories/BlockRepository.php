<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\BlockRepository as TwillBlockRepository;

class BlockRepository extends TwillBlockRepository
{
    public function create(array $fields): TwillModelContract
    {
        // Clean content before creating
        $fields = $this->cleanBlockContent($fields);
        return parent::create($fields);
    }

    public function update(int|string $id, array $fields): TwillModelContract
    {
        // Clean content before updating
        $fields = $this->cleanBlockContent($fields);
        return parent::update($id, $fields);
    }

    private function cleanBlockContent(array $fields): array
    {
        // Only clean the content field for blocks
        if (isset($fields['content']) && (is_array($fields['content']) || is_object($fields['content']))) {
            $content = is_object($fields['content']) ? (array) $fields['content'] : $fields['content'];

            foreach ($content as $fieldName => $fieldValue) {
                if (is_array($fieldValue) || is_object($fieldValue)) {
                    $nestedContent = is_object($fieldValue) ? (array) $fieldValue : $fieldValue;

                    foreach ($nestedContent as $langKey => $langValue) {
                        if (is_string($langValue) && preg_match('/<[^>]+>/', $langValue)) {
                            $cleanedValue = $this->cleanInsubstantialContent($langValue);
                            $nestedContent[$langKey] = $cleanedValue;
                        }
                    }

                    $content[$fieldName] = $nestedContent;
                }
            }

            $fields['content'] = $content;
        }

        return $fields;
    }

    private function cleanInsubstantialContent(string $content): string
    {
        // Trim whitespace
        $content = trim($content);

        // If empty, return empty string
        if (empty($content)) {
            return '';
        }

        // Remove all types of empty/whitespace-only paragraphs
        $content = preg_replace('/<p>\s*(<br[^>]*>)?\s*<\/p>/', '', $content);

        // Remove trailing softbreak paragraphs
        $content = preg_replace('/(<p>\s*<br[^>]*class=["\']softbreak["\'][^>]*>\s*<\/p>\s*)+$/', '', $content);

        // Check if substantial content remains
        $stripped = trim(strip_tags(preg_replace('/<br[^>]*>|<div[^>]*>\s*<\/div>/', '', $content)));

        return empty($stripped) ? '' : trim($content);
    }
}
