<?php

namespace App\Helpers;

class BlockHelpers
{

    /**
     * Sorts a list of blocks by the order in which they are set in the config.
     */
    public static function getBlocksForEditor($toUse = [])
    {
        $allBlocks = config('twill.block_editor.block-order');

        return array_intersect($allBlocks, $toUse);
    }

    /**
     * Get inner HTML of a DOM node
     * @see https://stackoverflow.com/questions/2087103/how-to-get-innerhtml-of-domnode
     */
    public static function innerHTML($node)
    {
        return implode(array_map(
            [$node->ownerDocument, 'saveHTML'],
            iterator_to_array($node->childNodes)
        ));
    }

    public static function getCaptionFields($title, $subtitle, $urlTitle = null)
    {
        global $_allowAdvancedModalFeatures;

        $fields = [
            'captionTitle' => $title,
            'caption' => $subtitle,
        ];

        if ($_allowAdvancedModalFeatures ?? false) {
            $wrappedCaptionTitle = $title ? '<div class="f-caption-title">' . $title . '</div>' : '';
            $wrappedCaption = $subtitle ? '<div class="f-caption">' . $subtitle . '</div>' : '';

            $fields['credit'] = htmlspecialchars($wrappedCaptionTitle . $wrappedCaption);
        }

        return $fields;
    }
}
