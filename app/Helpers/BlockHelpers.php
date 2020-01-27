<?php

if (!function_exists('getBlocksForEditor')) {
    /**
     * Sorts a list of blocks by the order in which they are set in the config.
     */
    function getBlocksForEditor($toUse = [])
    {
        $allBlocks = array_keys(config('twill.block_editor.blocks'));

        // Hide 3D blocks from production until they're ready for production use
        if ( app()->environment('production')) {
            $allBlocks = array_except($allBlocks, ['3d_model', '3d_tour', '3d_embed']);
        }

        return array_intersect($allBlocks, $toUse);
    }
}

// https://stackoverflow.com/questions/2087103/how-to-get-innerhtml-of-domnode
if (!function_exists('innerHTML')) {
    function innerHTML($node) {
        return implode(array_map([$node->ownerDocument,'saveHTML'],
                                 iterator_to_array($node->childNodes)));
    }
}

if (!function_exists('getTitleWithFigureNumber')) {
    function getTitleWithFigureNumber($title) {
        global $_figureCount;

        if (isset($_figureCount) && isset($title)) {
            $_figureCount++;

            $figPrefix = 'Fig. ' . $_figureCount . ': ';

            $dom = new DomDocument();
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $title, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // Plain text automatically gets wrapped in p-tag during loadHTML
            $firstChild = $dom->documentElement->firstChild ?? null;

            // Just a failsafe to prevent breaking the page
            if (!isset($firstChild)) {
                $_figureCount--;
                return $title;
            }

            $figTextNode = $dom->createTextNode($figPrefix);
            $figTextNode = $dom->documentElement->insertBefore(clone $figTextNode, $firstChild);

            $title = $dom->saveHTML($dom->documentElement);
        }

        return $title;
    }
}

if (!function_exists('getSubtitleWithFigureNumber')) {
    function getSubtitleWithFigureNumber($subtitle, $title) {
        return isset($title) ? $subtitle : getTitleWithFigureNumber($subtitle);
    }
}

