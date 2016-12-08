<?php

namespace App\Http\Middleware;

use App\Common\MiddlewareExceptTrait;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    //use MiddlewareExceptTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }
        return $next($request);
    }

//
//    public function handle($request, Closure $next, $guard = null)
//    {
//
//        die($request->decodedPath());
//        if ($this->shouldPassThrough($request)) {
//         die("xx");
//        } elseif (Auth::guard($guard)->check()) {
//            die("xx");
//            return redirect('/home');
//        }
//        return $next($request);
//
//    }
//
//    protected $except = [
//
//    ];
//    protected $exceptReg = [
//        '/profile/\d+'
//    ];
}
