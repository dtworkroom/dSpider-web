<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Common\ResponseData;
use Illuminate\Http\Request;
use App\Http\Requests;
use stdClass;

class ProfileController extends Controller
{
    public function index(Request $rq,$id=0){

        $user=$rq->user();
        $ob=new stdClass();
        $ob->id=$user->id;
        $ob->name=$user->name;
        $ob->email=$user->email;
        $ob->appKey=$user->appKeys;

        return ResponseData::okResponse($ob) ;
    }

}
