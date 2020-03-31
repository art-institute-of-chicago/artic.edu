<?php

namespace App\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;
use Illuminate\Http\Request;
use Closure;
use Cache;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $proxies = [];

    /**
     * The headers that should be used to detect proxies.
     *
     * @var string
     */
    protected $headers = Request::HEADER_X_FORWARDED_AWS_ELB;

    /**
     * Add remote address to trusted proxy list
     */
    public function handle(Request $request, Closure $next)
    {
        $ips = Cache::remember('list-cloudfront-ips', 60, function () {
            return '{"CLOUDFRONT_GLOBAL_IP_LIST": ["144.220.0.0/16", "52.124.128.0/17", "54.230.0.0/16", "54.239.128.0/18", "52.82.128.0/19", "99.84.0.0/16", "204.246.172.0/24", "54.239.192.0/19", "70.132.0.0/18", "13.32.0.0/15", "205.251.208.0/20", "13.224.0.0/14", "13.35.0.0/16", "204.246.164.0/22", "204.246.168.0/22", "71.152.0.0/17", "216.137.32.0/19", "205.251.249.0/24", "99.86.0.0/16", "52.46.0.0/18", "52.84.0.0/15", "204.246.173.0/24", "130.176.0.0/16", "205.251.200.0/21", "204.246.174.0/23", "64.252.128.0/18", "205.251.254.0/24", "143.204.0.0/16", "205.251.252.0/23", "204.246.176.0/20", "13.249.0.0/16", "54.240.128.0/18", "205.251.250.0/23", "52.222.128.0/17", "54.182.0.0/16", "54.192.0.0/16", "64.252.64.0/18"], "CLOUDFRONT_REGIONAL_EDGE_IP_LIST": ["13.124.199.0/24", "34.226.14.0/24", "52.15.127.128/26", "35.158.136.0/24", "52.57.254.0/24", "18.216.170.128/25", "13.52.204.0/23", "13.54.63.128/26", "13.59.250.0/26", "13.210.67.128/26", "35.167.191.128/26", "52.47.139.0/24", "52.199.127.192/26", "52.212.248.0/26", "52.66.194.128/26", "13.113.203.0/24", "99.79.168.0/23", "34.195.252.0/24", "35.162.63.192/26", "34.223.12.224/27", "52.56.127.0/25", "34.223.80.192/26", "13.228.69.0/24", "34.216.51.0/25", "3.231.2.0/25", "54.233.255.128/26", "18.200.212.0/23", "52.52.191.128/26", "3.234.232.224/27", "52.78.247.128/26", "52.220.191.0/26", "34.232.163.208/29"]}';
        });

        $ips = json_decode($ips);

        $this->proxies = array_merge(
            $this->proxies,
            $ips->{"CLOUDFRONT_GLOBAL_IP_LIST"},
            $ips->{"CLOUDFRONT_REGIONAL_EDGE_IP_LIST"}
        );

        array_push($this->proxies, $request->server->get('REMOTE_ADDR'));
        return parent::handle($request, $next);
    }
}
