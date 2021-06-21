<?php

/**
 * WEB-754: This overrides the `revAsset` function shipped with Twill.
 * The original function uses `Cache` to store the contents of the manifest.
 * We run `cache:clear` after deploy, but for an unknown reason, sometimes,
 * this did not reset the `rev-manifest`. Possibly happens if a request starts
 * before cache gets cleared, but finishes afterwards? Unclear. This fixes the
 * issue by not caching the manifest contents. Caching might not have much
 * impact on performance.
 *
 * @link https://stackoverflow.com/questions/9555658/why-is-file-get-contents-faster-than-memcache-get
 */
if (!function_exists('revAsset')) {
    /**
     * @param string $file
     * @return string
     */
    function revAsset($file)
    {
        if (!app()->environment('local', 'development')) {
            try {
                $manifest = json_decode(file_get_contents(config('twill.frontend.rev_manifest_path')), true);

                if (isset($manifest[$file])) {
                    return (rtrim(config('twill.frontend.dist_assets_path'), '/') . '/') . $manifest[$file];
                }
            } catch (\Exception $e) {
                return '/' . $file;
            }
        }

        return (rtrim(config('twill.frontend.dev_assets_path'), '/') . '/') . $file;
    }
}
