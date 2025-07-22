<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class UpdateCDNIps extends Command
{
    protected $signature = 'update:cdn-ips';

    protected $description = 'Update file cache of CDN IPs for TrustProxies';

    public function handle()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.cloudflare.com/client/v4/ips');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . config('services.cloudflare.key'),
        ]);

        $contents = curl_exec($ch);
        curl_close($ch);

        if ($contents === false) {
            return 0;
        }

        Storage::put('list-cdn-ips.json', $contents);

        $this->info('CDN IPs updated!');
    }
}
