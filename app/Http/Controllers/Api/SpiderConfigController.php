<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Common\ResponseData;
use App\Spider;
use App\SpiderConfig;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class SpiderConfigController extends Controller
{

    public function save(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'spider_id' => 'required|Numeric',
            'appKey_id' => 'required'
        ]);

        if ($validator->fails()) {
            return ResponseData::errorResponse($validator->errors()->first());
        }

        if(isset($data["id"])){
            $config=SpiderConfig::find($data["id"]);
        }else {
            $config=SpiderConfig::where([
                ["spider_id", $data["spider_id"]],
                ["appKey_id", $data["appKey_id"]]
            ])->first();
            if($config){
               return ResponseData::okResponse($config->id);
            }
            $config = new SpiderConfig();
        }
        $spider=Spider::find($data["spider_id"]);

        if($spider->user_id!=$request->user()->id && $spider->public){
            return ResponseData::errorResponse("The spider is not public!");
        }

        $config->spider_id = $data["spider_id"];
        $config->content=$data["content"]??null;
        $config->appKey_id=$data["appKey_id"];
        $config->save();
        return ResponseData::okResponse($config->id);

    }

    public function  delete(Request $request, $id)
    {
        $user = $request->user();
        $appkeys = array_map(function ($item) {
            return $item['id'];
        }, $user->appKeys->toArray());
        $config= SpiderConfig::where("id", $id)->whereIn('appKey_id', $appkeys)->first();
        $config->delete();
        return ResponseData::okResponse($config->id);
    }

    public function getById(Request $request, $id)
    {
        $config = SpiderConfig::find($id);
        return ResponseData::okResponse($config);
    }

    public function getAllByUser(Request $request)
    {
//        $records=array_map(function($item){
//
//        },$request->user()->appKeys->toArray());
        return ResponseData::okResponse();
    }

}
