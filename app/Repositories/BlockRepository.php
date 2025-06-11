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

        // Remove empty paragraphs with just breaks or softbreaks
        $content = preg_replace('/<p>\s*<br[^>]*>\s*<\/p>/', '', $content);
        $content = preg_replace('/<p>\s*<br[^>]*class=["\']softbreak["\'][^>]*>\s*<\/p>/', '', $content);
        $content = preg_replace('/<p>\s*<\/p>/', '', $content);

        // Check if there's substantial content left
        $strippedContent = preg_replace('/<p>\s*(<br[^>]*>)?\s*<\/p>/', '', $content);
        $strippedContent = preg_replace('/<br[^>]*>/', '', $strippedContent);
        $strippedContent = preg_replace('/<div[^>]*>\s*<\/div>/', '', $strippedContent);
        $strippedContent = trim(strip_tags($strippedContent));

        // If no substantial content remains, return empty string
        if (empty($strippedContent)) {
            return '';
        }

        // Clean up trailing softbreak paragraphs at the end
        $content = preg_replace('/(<p>\s*<br[^>]*class=["\']softbreak["\'][^>]*>\s*<\/p>\s*)+$/', '', $content);

        // Final trim
        $content = trim($content);

        // Return cleaned content or empty string if nothing substantial
        return empty($content) ? '' : $content;
    }
}
