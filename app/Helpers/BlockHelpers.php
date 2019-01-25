<?php

if (!function_exists('getBlocksForEditor')) {
    /**
     * Sorts a list of blocks by the order in which they are set in the config.
     */
    function getBlocksForEditor($toUse = [])
    {
        return array_intersect(array_keys(config('twill.block_editor.blocks')), $toUse);
    }
}
