<?php

namespace App\Http\Middleware;

use App\Common\ResponseData;
use Closure;

class Https
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->getScheme()!="https" ) {
            return ResponseData::errorResponse("The protocol must be https!");
        }
        return $next($request);
    }
}
