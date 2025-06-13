<?php

namespace App\Services\Cache;

use Illuminate\Support\Facades\Log;
use Monolog\Utils;

class CloudflareCacheService
{
    /**
     * @param string[] $urls
     * @return void
     */
    public function purge($paths = [])
    {
        if ($paths !== []) {
            try {
                $postData = [
                    'files' => $paths,
                ];
                $postString = Utils::jsonEncode($postData);

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://api.cloudflare.com/client/v4/zones/' . config('services.cloudflare.zone_id') . '/purge_cache');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Content-Type: application/json",
                    "Authorization: Bearer " . config('services.cloudflare.key'),
                ]);

                ob_start();
                curl_exec($ch);
                curl_close($ch);
                $string = ob_get_contents();
                ob_end_clean();

                $res = json_decode($string);

                if (!$res->success) {
                    Log::debug('Cloudflare purge returned with a failed response');
                }
            } catch (\Exception) {
                Log::debug('Cloudflare purge failed in making HTTP API request');
            }
        }
    }
}
