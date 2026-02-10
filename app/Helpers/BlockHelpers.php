<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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

    /**
     * Get the heading field from the content of each block, formatted as a
     * label and an anchor target. For use in generating landing page subnavs.
     */
    public static function getHeadings(Collection $blocks): Collection
    {
        return $blocks
          ->filter(fn ($block) => strlen(strip_tags($block->present()->input('heading') ?? '')))
          ->map(function ($block) {
              $heading = strip_tags($block->present()->input('heading'));
              return [
                  'label' => $heading,
                  'target' => '#' . Str::slug(html_entity_decode($heading))
              ];
          });
    }
}
