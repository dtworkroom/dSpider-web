<?php

namespace App\Http\Middleware;

use App\Common\ResponseData;
use Closure;

class SdkApi
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
        if($request->getHost()=="api.dtworkroom.com"){
            return $next($request);
        }else{
            return ResponseData::errorResponse("Domain error!");
        }
    }
}
