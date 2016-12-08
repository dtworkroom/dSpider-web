<?php

namespace App\Http\Middleware;

use App\Common\MiddlewareExceptTrait;
use App\Common\ResponseData;
use Closure;
use Illuminate\Support\Facades\Auth;
class ApiAuthMiddleware
{

     use MiddlewareExceptTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if($this->shouldPassThrough($request)||Auth::check()){
            return $next($request);
        } else{
            return ResponseData::toJson(ResponseData::ERROR_NEED_LOGIN);
        }
    }

    private $exceptReg = [
      '/user/spider/\d+'
    ];
}
