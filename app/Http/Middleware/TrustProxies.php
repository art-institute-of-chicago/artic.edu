<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Closure;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array|string|null
     */
    protected $proxies = [];

    /**
     * The proxy header mappings.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_AWS_ELB;

    /**
     * Add remote address to trusted proxy list
     *
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle(Request $request, Closure $next)
    {
        $ips = Cache::remember('list-cdn-ips', 60 * 60, function () {
            if (Storage::exists('list-cdn-ips.json')) {
                return Storage::get('list-cdn-ips.json');
            }

            return '{"result": {"ipv4_cidrs": []}}';
        });

        $ips = json_decode($ips);

        $this->proxies = array_merge(
            $this->proxies,
            $ips->{'result'}->{'ipv4_cidrs'} ?? [],
        );

        array_push($this->proxies, $request->server->get('REMOTE_ADDR'));

        return parent::handle($request, $next);
    }
}
