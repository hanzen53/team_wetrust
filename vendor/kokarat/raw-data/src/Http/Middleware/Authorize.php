<?php

namespace Kokarat\RawData\Http\Middleware;

use Kokarat\RawData\RawData;

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
        return resolve(RawData::class)->authorize($request) ? $next($request) : abort(403);
    }
}
