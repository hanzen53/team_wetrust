<?php

namespace Kokarat\ImeiStatus\Http\Middleware;

use Kokarat\ImeiStatus\ImeiStatus;

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
        return resolve(ImeiStatus::class)->authorize($request) ? $next($request) : abort(403);
    }
}
