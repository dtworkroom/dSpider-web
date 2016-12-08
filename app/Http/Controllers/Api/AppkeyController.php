<?php

namespace App\Http\Controllers\Api;

use App\AppKey;
use App\Common\Utils;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Common\ResponseData;
use App\SpiderConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppKeyController extends Controller
{
    public function index(Request $request)
    {
        return ResponseData::okResponse(AppKey::all());
    }

    public function save(Request $request)
    {
        $data = $request->all();
        if (!isset($data["secret"])) {
            $data["secret"] = Utils::getRandChar(32);
        }
        $validator = Validator::make($data, [
            'secret' => 'required|min:6|max:255',
            'name'=>'required|max:255'
        ]);

        if ($validator->fails()) {
            return ResponseData::errorResponse($validator->errors()->first());
        }

        if (isset($data["id"])) {
            $appKey = AppKey::find($data["id"]);
        } else {
            $appKey = new AppKey();
            //每一个新的Appkey默认授权测试脚本
            $config=new SpiderConfig();
            $config->spider_id=1;
        }
        $appKey->secret = $data["secret"];
        $appKey->user_id = $request->user()->id;
        $appKey->name=$data["name"];
        $appKey->save();
        if($config){
            $config->appKey_id=$appKey->id;
            $config->save();
        }
        return ResponseData::okResponse($appKey->id);

    }

    public function delete(Request $request, $id)
    {
        $appkey = AppKey::find($id);
        $appkey->delete();
        return ResponseData::okResponse($appkey->id);
    }

    public function getById(Request $request, $id)
    {
        $appkey = AppKey::find($id);
        return ResponseData::okResponse($appkey);
    }

    public function getConfigs(Request $request,$id)
    {
        $appkey = AppKey::find($id);
        return ResponseData::okResponse($appkey->spiderConfigs);
    }


}
