<?php

namespace Kokarat\DltMasterFile\Http\Middleware;

use Kokarat\DltMasterFile\DltMasterFile;

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
        return resolve(DltMasterFile::class)->authorize($request) ? $next($request) : abort(403);
    }
}
