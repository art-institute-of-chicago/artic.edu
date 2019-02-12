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

/**
 * Putting this here because it fixes a blocker.
 *
 * @link https://medium.com/@radicalloop/laravel-dd-var-function-is-not-working-in-new-chrome-9bc2aa689b9a
 * @link https://bugs.chromium.org/p/chromium/issues/detail?id=930061
 */
if (!function_exists('ddd')) {
    function ddd(...$args)
    {
        if (!headers_sent()) {
            header('HTTP/1.1 500 Internal Server Error');
        }
        call_user_func_array('dd', $args);
    }
}
