<?php

namespace App\Middleware;

use App\Contracts\Middleware;
use App\Http\Request;
use App\Http\Response;
use App\Utils\Cache\File as CacheFile;
use Closure;

class Cache implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isCacheable($request)) {
            return $next($request);
        }

        $hash = $this->getHash($request);

        return CacheFile::getCache($hash, CACHE_TIME, function () use ($request, $next) {
            return $next($request);
        });
    }

    private function isCacheable(Request $request)
    {
        header('Cache-Control:12');
        if (CACHE_ENABLE !== true || CACHE_TIME <= 0) return false;
        if ($request->getMethod() !== 'GET') return false;

        // $cacheControl = $request->getHeaders('Cache-Control', '');
        // if (strpos($cacheControl, 'no-cache') !== false) return false;

        return true;
    }

    private function getHash(Request $request)
    {
        $uri = $request->getUri();
        $queryParams = $request->getParams();
        $uri .= empty($queryParams) ? '' : '?' . http_build_query($queryParams);

        return rtrim('route-' . preg_replace('/[^0-9a-zA-Z]/', '-', ltrim($uri, '/')), '-');
    }
}
