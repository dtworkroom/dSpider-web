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
    public function save(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'os_type' => 'required|Numeric',
            'os_version'=>'required',
            'model'=>'required',
            'identifier'=>'required'

        ]);
        if ($validator->fails()) {
            return ResponseData::errorResponse(
                $validator->errors()->first());
        }
        $device = Device::where([
            ["os_type", $data['os_type']],
            ["identifier", $data['identifier']]
        ])->first();
        if(!$device){
            $device=new Device();
        }
        foreach ($data as $key => $value) {
            $device->$key = $value;
        }
        $device->save();
        return ResponseData::okResponse($device->id);
    }

    public function info($id){
      $device= Device::find($id);
      if($device){
          return ResponseData::okResponse($device);
      } else{
          return ResponseData::errorResponse("Incorrect device id");
      }
    }
}
