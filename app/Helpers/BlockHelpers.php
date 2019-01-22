<?php

if (!function_exists('getBlocksForEditor')) {
    /**
     * Sorts a list of blocks by the order in which they are set in the config.
     */
    function getBlocksForEditor($toUse = [])
    {
        $all = array_keys(config('twill.block_editor.blocks'));
        $forEditor = [];

        foreach ($all as $block) {
            if (in_array($block, $toUse)) {
                $forEditor[] = $block;
            }
        }

        return $forEditor;
    }
}
