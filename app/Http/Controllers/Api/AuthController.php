<?php

namespace App\Http\Controllers\Api;

use App\Common\ResponseData;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->remember)) {
            return ResponseData::okResponse( Auth::user()->id);
        }
        return ResponseData::errorResponse("Incorrect email or password");
    }
}
