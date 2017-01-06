<?php

namespace App\Http\Controllers\Api;

use App\Common\ResponseData;
use App\Device;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{

    public function info($id){
      $device= Device::find($id);
      if($device){
          return ResponseData::okResponse($device);
      } else{
          return ResponseData::errorResponse("Incorrect device id");
      }
    }
}
