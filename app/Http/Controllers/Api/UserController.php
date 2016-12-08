<?php

namespace App\Http\Controllers\Api;

use App\Common\ResponseData;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use stdClass;

class UserController extends Controller
{
    public function index(Request $rq,$id=0){
        $user=User::find($id);

        $ob=new stdClass();
        $ob->id=$user->id;
        $ob->name=$user->name;
        //$ob->email=$user->email;
        return ResponseData::okResponse($user) ;
    }
}
