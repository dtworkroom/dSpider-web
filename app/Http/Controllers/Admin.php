<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Route;

class Admin extends Controller
{

    public function index(Request $request)
    {
        echo  "admins";
        echo  $s=Route::currentRouteAction();
        echo  action("Test@index",[1,"dd"]);
        echo "<br />";
        echo $request->path();

    }

}
