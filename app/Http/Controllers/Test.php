<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Test extends Controller
{

    public function index(Request $request,$ids,$name="wendu")
    {
        $this->pn(__METHOD__,$request->method(),$request->url());

    }

    public function test(Request $request)
    {
        $this->pn(__METHOD__,$request->method(),$request->url());
        var_dump($request->all());

    }

}
