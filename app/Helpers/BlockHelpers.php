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
