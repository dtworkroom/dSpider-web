<?php

namespace App\Http\Controllers;

use App\Level;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Route;

class Account extends Controller
{

    public function login(Request $request)
    {
        $level=new Level();
        $level->appKey=1;
        $level->level=2;
        $level->levelw=4;
        $level->save();
        echo $request->path();
    }

}
