<?php

/**
 * Created by PhpStorm.
 * User: du
 * Date: 16/12/2
 * Time: 上午11:01
 */
namespace App\Common;
trait MiddlewareExceptTrait
{
    public function shouldPassThrough($request)
    {
        return $this->isExcept($request, $this->except??[]) ||
        $this->isExcept($request, $this->exceptReg??[], true);
    }

    public function isExcept($request, $excepts, $reg = false)
    {

        foreach ($excepts as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }
            if ($reg) {
                return (bool)preg_match('#^' . $except . '\z#u', $request->decodedPath());
            } else {
                return $request->is($except);
            }
        }
        return false;
    }

}