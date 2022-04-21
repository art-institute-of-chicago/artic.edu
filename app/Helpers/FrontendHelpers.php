<?php

namespace App\Helpers;

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
class FrontendHelpers
{

    /**
     * @param string $file
     * @return string
     */
    public static function revAsset($file)
    {
        if (config('aic.use_compiled_revassets')) {
            $manifest = json_decode(file_get_contents(config('twill.frontend.rev_manifest_path')), true);

            if (isset($manifest[$file])) {
                return (rtrim(config('twill.frontend.dist_assets_path'), '/') . '/') . $manifest[$file];
            }
        }

        return (rtrim(config('twill.frontend.dev_assets_path'), '/') . '/') . $file;
    }

    /**
     * @param string $file
     * @return string
     */
    public static function embedAsset($file)
    {
        if (config('aic.use_compiled_revassets')) {
            $manifest = json_decode(file_get_contents(config('twill.frontend.rev_manifest_path')), true);

            if (isset($manifest[$file])) {
                return file_get_contents(FrontendHelpers::dist_path($manifest[$file]));
            }
        }

        return file_get_contents(FrontendHelpers::dist_path($file));
    }

    /**
     * Returns the fully qualified path to the application's `frontend` directory.
     * You may generate a fully qualified path to a file relative to the frontend directory.
     */
    public static function dist_path($file = null)
    {
        return base_path() . '/public' . config('twill.frontend.dist_assets_path') . (!empty($file) ? '/' . $file : '');
    }
}
