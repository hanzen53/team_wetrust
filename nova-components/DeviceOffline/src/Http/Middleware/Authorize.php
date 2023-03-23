<?php

namespace Kokarat\DeviceOffline\Http\Middleware;

use Kokarat\DeviceOffline\DeviceOffline;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(DeviceOffline::class)->authorize($request) ? $next($request) : abort(403);
    }
}
