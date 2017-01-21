<?php

namespace App\Http\Controllers\Api;

use App\Common\JSMin;
use App\Common\ResponseData;
use App\CrawlRecord;
use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Spider;
use App\SpiderConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpiderController extends Controller
{

    public function index(Request $request)
    {
        $records = Spider::paginate($request->input("pageSize", 20));
        $records->map(function ($item) {
            $item["size"] = strlen($item["content"]);
            unset($item["content"]);
            unset($item["readme"]);
            return $item;
        });
        $records->setPath($request->fullUrl());
        return ResponseData::okResponse($records);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:50',
            'content' => 'required',
            'startUrl' => 'required',
            "description" => 'required|max:255'
        ]);

        unset($data['size']);
        $data["public"] = $data["public"] == "false" ? false : true;
        //unset($data['updated_at']);
        //unset($data['created_at']);

        if ($validator->fails()) {
            return ResponseData::errorResponse($validator->errors()->first());
        }
        $user = $request->user();
        if ($data['id']) {
            $spider = Spider::find($data['id']);
        } else {
            $spider = new Spider();
        }

        trim($data["defaultConfig"])||$data["defaultConfig"]=null;
        trim($data["readme"])||$data["readme"]=null;
        mergeObject($spider, $data);

        foreach ($data as $key => $value) {
            $spider->$key = $value;
        }

        $spider->user_id = $user->id;
        $spider->save();
        return ResponseData::okResponse($spider->id);

    }

    public function delete(Request $request, $id)
    {
        $spider = Spider::find($id);
        $spider->delete();
        return ResponseData::okResponse($spider->id);
    }


//    public function getByAppkey(Request $request, $id)
//    {
//        $spider = Spider::find($id);
//        $spider->size = strlen($spider->content);
//        return ResponseData::okResponse($spider);
//    }

    public function getById(Request $request, $id)
    {
        $spider = Spider::find($id);
        if (!$spider) {
            return ResponseData::errorResponse("Incorrect id!");
        }
        $spider->size = strlen($spider->content);
        //该脚本作者不是当前用户时鉴权
        if (!($request->user() && $request->user()->id==$spider->user_id)) {
            if(!$spider->public){
                return ResponseData::errorResponse("No permission for this spider!");
            }
            if (!($spider->access & Spider::ACCESS_READ)) {
                unset($spider->content);
            }
        }
        $spider->size = strlen($spider->content);
        return ResponseData::okResponse($spider);


    }

    public function getAllByUser(Request $request)
    {
        $records = $request->user()->spiders->map(function ($item) {
            $item["size"] = strlen($item["content"]);
            unset($item["content"]);
            unset($item["readme"]);
            return $item;
        });
        return ResponseData::okResponse($records);
    }

    public function getTask(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'sid' => 'required',
            'appkey' => 'required',
            'device_id' => 'required',
            'sdk_version' => 'required'

        ]);

        if ($validator->fails()) {
            return ResponseData::errorResponse($validator->errors()->first());
        }
        $sid = $data["sid"];
        $spider = Spider::find($sid);
        $config = SpiderConfig::where([
            ["spider_id", $sid],
            ["appKey_id", $request->appkey]
        ])->first();

        if (!($config && ($spider->access & Spider::ACCESS_DISPATCH))) {
            return ResponseData::errorResponse("No permission for this script!");
        }

        if (!$config->online) {
            return ResponseData::errorResponse("The script is offline!");
        }

        $platform = $request->input("platform", "ios");
        if ($platform == "android") {
            $support = Spider::SUPPORT_ANDROID;
        } elseif ($platform == "pc") {
            $support = Spider::SUPPORT_PC;
        } else {
            $support = Spider::SUPPORT_IOS;
        }
        //是否支持当前平台
        if (!($spider->support & $support)) {
            return ResponseData::errorResponse("The spider doesn't support " . $platform);
        }

        $crawRecords = new CrawlRecord();
        $crawRecords->spider_id = $sid;
        $crawRecords->appKey_id = $request->appkey;
        $crawRecords->config = $config->content??$spider->defaultConfig;
        $crawRecords->device_id = $data["device_id"];
        $crawRecords->sdk_version = $data["sdk_version"];
        $crawRecords->app_version = $data["app_version"];
        $crawRecords->save();

        $ret = ["id" => $crawRecords->id, "startUrl" => $spider->startUrl];
        return ResponseData::okResponse($ret);
    }

    public function getScript(Request $request)
    {
        $data = $request->all();
        $data["appkey"] = intval($data["appkey"]);
        $validator = Validator::make($data, [
            'id' => 'required|Numeric',
            "appkey" => 'required|Numeric',
        ]);
        if ($validator->fails()) {
            return ResponseData::errorResponse(
                $validator->errors()->first());
        }
        $record = CrawlRecord::find($data["id"]);
        if (!($record && $record->appKey_id == $data["appkey"])) {
            return ResponseData::errorResponse("Illegal operation");
        }
        $spider = $record->spider;
        if ($request->method() == "GET") {
            if ($spider->user_id != $record->appKey->user_id && !($spider->access & Spider::ACCESS_READ)) {
                return ResponseData::errorResponse("No read permission for this spider source!");
            }
        }
        $record->state = CrawlRecord::STATE_CRAWLING;
        $record->save();

        //脚本总调用次数自增
        $spider->callCount = $spider->callCount + 1;
        $spider->save();
        $code = "!function(){\r\nvar _config=%s;\r\n%s;\r\n%s}()";
        $src = "";
        $platform = $request->input("platform", Device::IPHONE);
        if ($platform < Device::WINDOWS) {
            $src = file_get_contents(__DIR__ . "/Spiders/common/utils.js") . "\r\n";
        }
        if ($platform == Device::ANDROID) {
            $src .= file_get_contents(__DIR__ . "/Spiders/common/jsBridgeAndroid.js");
        } elseif ($platform == Device::IPHONE) {
            $src .= file_get_contents(__DIR__ . "/Spiders/common/jsBridgeIos.js");
        }
        $src .= "\r\n" . $spider->content . "\r\n";
        $scriptUrl = 'var _su="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"';
        $code = sprintf($code, $record->config??"{}", $scriptUrl, $src);
        if (!env("APP_DEBUG")) {
            $code = JSMin::minify($code);
        }
        return response($code)->header("Content-Type", "text/javascript; charset=utf-8");
    }

}
