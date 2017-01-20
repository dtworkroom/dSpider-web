<?php

namespace App\Http\Controllers\Api;

use App\AppKey;
use App\Common\JSMin;
use App\Common\ResponseData;
use App\Http\Controllers\Controller;
use App\CrawlRecord;
use App\Device;
use App\Http\Requests;
use App\Spider;
use App\SpiderConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SdkController extends Controller
{


    public function __construct()
    {
        //$this->middleware("api");
    }


    public function _saveDevice(Request $request){
        $data = $request->all();
        //兼容bundle_id
        if(isset($data['mac_id'])){
            $data['identifier']=$data['mac_id'];
        }
        if(isset($data['os'])){
            $data['os_type']=$data['os'];
        }
        $validator = Validator::make($data, [
            'os_type' => 'required',
            'os_version'=>'required',
            'model'=>'required',
            'identifier'=>'required'

        ]);
        if ($validator->fails()) {
            die (ResponseData::errorResponse($validator->errors()->first())->getContent());
        }
        $device = Device::where([
            ["os_type", $data['os_type']],
            ["identifier", $data['identifier']]
        ])->first();
        if(!$device){
            $device=new Device();
            $device->identifier=$data['mac_id'];
            $device->os_type=$data['os_type'];
            $device->os_version=$data['os_version'];
            $device->model=$data['model'];

            $device->save();
        }
        return $device->id;
    }

    public function saveDevice(Request $request){

        return ResponseData::okResponse($this->_saveDevice($request));
    }

    public function getTask(Request $request)
    {
        $data = $request->all();
        //兼容bundle_id
        if(isset($data['bundle_id'])){
            $data['package']=$data['bundle_id'];
        }
        $validator = Validator::make($data, [
            'sid' => 'required',
            'package' => 'required',
            'sdk_version' => 'required'
        ]);

        if ($validator->fails()) {
            return ResponseData::errorResponse($validator->errors()->first());
        }
        $sid = $data["sid"];
        $spider = Spider::find($sid);
        $app=AppKey::where("package",$data['package'])->first();
        if(!$app){
            return ResponseData::errorResponse("The app {$data['package']} is not exist!");
        }
        $config = SpiderConfig::where([
            ["spider_id", $sid],
            ["appKey_id", $app->id]
        ])->first();

        if (!($config && ($spider->access & Spider::ACCESS_DISPATCH))) {
            return ResponseData::errorResponse("No permission for this script!");
        }

        if (!$config->online) {
            return ResponseData::errorResponse("The script is offline!");
        }

        $platform = $request->input("os");
        if ($platform ==Device::ANDROID) {
            $support = Spider::SUPPORT_ANDROID;
        } elseif ($platform ==Device::IPHONE) {
            $support = Spider::SUPPORT_IOS;
        } else {
            $support = Spider::SUPPORT_PC;
        }
        //是否支持当前平台
        if (!($spider->support & $support)) {
            return ResponseData::errorResponse("The spider doesn't support " . $platform);
        }

        $crawRecords = new CrawlRecord();
        $crawRecords->spider_id = $sid;
        $crawRecords->appKey_id = $app->id;
        $crawRecords->config = $config->content??$spider->defaultConfig;
        $crawRecords->device_id = $this->_saveDevice($request);
        $crawRecords->sdk_version = $data["sdk_version"];
        $crawRecords->app_version = $data["app_version"];
        $crawRecords->state=CrawlRecord::STATE_CRAWLING;
        $crawRecords->save();
        //分发脚本
        $spider = $crawRecords->spider;
        $spider->callCount = $spider->callCount + 1;
        $config->callCount= $config->callCount+1;
        $spider->save();
        $code = "!function(){\r\nvar _config=%s;\r\n%s;\r\n%s}()";
        $src = "";

        if ($platform < Device::WINDOWS) {
            $src = file_get_contents(__DIR__ . "/Spiders/common/sdk.js") . "\r\n";
        }
        $src .= "\r\n" . $spider->content . "\r\n";
        $scriptUrl = 'var _su="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"';
        $code = sprintf($code, $crawRecords->config??"{}", $scriptUrl, $src);
        if (!env("APP_DEBUG")) {
            $code = JSMin::minify($code);
        }
        $ret = ["id" => $crawRecords->id,"ua"=>$spider->ua, "startUrl" => $spider->startUrl,"script"=>$code,"script_count"=>1];
        return ResponseData::okResponse($ret);
    }

    public function getScript(Request $request)
    {
        $data = $request->all();
        //兼容bundle_id
        if(isset($data['bundle_id'])){
            $data['package']=$data['bundle_id'];
        }

        $validator = Validator::make($data, [
            'id' => 'required|Numeric',
            "package" => 'required|Numeric',
        ]);
        if ($validator->fails()) {
            return ResponseData::errorResponse(
                $validator->errors()->first());
        }


        $app=AppKey::where("package",$data['package'])->first();
        if(!$app){
            return ResponseData::errorResponse("The app {$data['package']} is not exist!");
        }
        $record = CrawlRecord::find($data["id"]);
        echo $record->config;
        if (!($record && $record->appKey_id == $app->id)) {
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

    //上报爬取结果
    public function reportState(Request $request)
    {
        $data = $request->all();
        //兼容bundle_id
        if(isset($data['bundle_id'])){
            $data['package']=$data['bundle_id'];
        }

        $validator = Validator::make($data, [
            'id' => 'required|Numeric',
            'state' => 'required|Numeric',
            'package' => 'required|Numeric',
        ]);

        if ($validator->fails()) {
            return ResponseData::errorResponse(
                $validator->errors()->first());
        }
        $app=AppKey::where("package",$data['package'])->first();
        if(!$app){
            return ResponseData::errorResponse("The app {$data['package']} is not exist!");
        }

        $record = CrawlRecord::find($data["id"]);
        if ($record->appKey_id != $app->id) {
            return ResponseData::errorResponse("Illegal operation");
        }

        $record->state = $data['state'];
        if ($data['msg']) {
            $record->msg = $data['msg'];
        }
        $record->save();
        return ResponseData::okResponse();
    }

}
