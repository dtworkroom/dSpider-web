<?php

namespace App\Http\Controllers\Api;

use App\AppKey;
use App\Common\JSMin;
use App\Common\SdkResponseData;
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
            $os= ["android"=>1,"ios"=>2,"pc"=>4][$data['os']];
            $data['os_type']=$os;
        }
        $validator = Validator::make($data, [
            'os_type' => 'required',
            'os_version'=>'required',
            'model'=>'required',
            'identifier'=>'required'

        ]);
        if ($validator->fails()) {
            die (SdkResponseData::errorResponse($validator->errors()->first())->getContent());
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

        return SdkResponseData::okResponse($this->_saveDevice($request));
    }

    public function getTask(Request $request)
    {
        $data = $request->all();
        //兼容bundle_id
        if(isset($data['bundle_id'])){
            $data['package']=$data['bundle_id'];
        }
        if(isset($data['soft_version'])){
            $data['app_version']=$data["soft_version"];
        }
        $validator = Validator::make($data, [
            'sid' => 'required',
            'package' => 'required',
            'retry'=>'required|Numeric',
            'sdk_version' => 'required',
            'app_version'=>'required',
            'app_id'=>'required'
        ]);

        if ($validator->fails()) {
            return SdkResponseData::errorResponse($validator->errors()->first());
        }
        $sid = $data["sid"];
        $spider = Spider::find($sid);
        $app=AppKey::where([["package",$data['package']],["id",$data["app_id"]]])->first();
        if(!$app){
            return SdkResponseData::errorResponse("包名: {$data['package']}, appId:{$data['app_id']} 的应用不存在! 请先在后台创建应用。");
        }
        $config = SpiderConfig::where([
            ["spider_id", $sid],
            ["appKey_id", $app->id]
        ])->first();

        if (!($config && ($spider->access & Spider::ACCESS_DISPATCH))) {
            return SdkResponseData::errorResponse("没有该spider的权限,请确保已将该spider添加到了您的应用并该爬虫允许下发。");
        }

        if (!$config->online) {
            return SdkResponseData::errorResponse("该爬虫已下线!");
        }

        $scripts=array_filter($spider->scripts->all(),function($item){
            if($item->online) return true;
        });

        $scriptsCount=count($scripts);
        if($scriptsCount==0||$data["retry"]>$scriptsCount){
            return SdkResponseData::errorResponse("没有可用的脚本了");
        }


        $platform = ["android"=>1,"ios"=>2,"pc"=>4][$request->input("os")];
        if ($platform ==Device::ANDROID) {
            $support = Spider::SUPPORT_ANDROID;
        } elseif ($platform ==Device::IPHONE) {
            $support = Spider::SUPPORT_IOS;
        } else {
            $support = Spider::SUPPORT_PC;
        }
        //是否支持当前平台
        if (!($spider->support & $support)) {
            return SdkResponseData::errorResponse("该脚本不支持 " . $platform);
        }

        $crawRecords = new CrawlRecord();
        $crawRecords->spider_id = $sid;
        $crawRecords->appKey_id = $app->id;
        $crawRecords->config = $config->content??$spider->defaultConfig;
        $crawRecords->device_id = $this->_saveDevice($request);
        $crawRecords->sdk_version = $data["sdk_version"];
        $crawRecords->app_version = $data["app_version"];
        $crawRecords->state=CrawlRecord::STATE_CRAWLING;
        $crawRecords->os_type=$support;
        //分发脚本
        $spider = $crawRecords->spider;
        $spider->callCount = $spider->callCount + 1;
        $config->callCount= $config->callCount+1;
        $spider->save();
        $config->save();

        $code = "!function(){\r\nvar _config=%s;\r\n%s;\r\n%s}()";
        $src = "";

        //选取脚本,按优先级排序
        usort($scripts,function($pre,$after){
         if($after->priority==$pre->priority){
             return 0;
         }
          return  $after->priority>$pre->priority?1:-1;
        });
        $script=$scripts[intval($data["retry"])-1];
        $script->callCount= $script->callCount+1;
        $script->save();
        $crawRecords->script_id=$script->id;
        $crawRecords->save();
        if ($platform < Device::WINDOWS) {
            $src = file_get_contents(__DIR__ . "/Spiders/common/sdk.js") . "\r\n";
        }

        $src .= "\r\n" . $script["content"] . "\r\n";
        $scriptUrl = 'var _su="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '"';
        $code = sprintf($code, $crawRecords->config??"{}", $scriptUrl, $src);
        if (!env("APP_DEBUG")) {
            $code = JSMin::minify($code);
        }
        $ret = ["id" => $crawRecords->id, "script_id"=>$script["id"], "ua"=>$spider->ua,
            "login_url" => $spider->startUrl,"script"=>$code,"script_count"=>$scriptsCount];
        return SdkResponseData::okResponse($ret);
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
            'task_id' => 'required|Numeric',
            'state' => 'required|Numeric',
            'package' => 'required',
        ]);

        if ($validator->fails()) {
            return SdkResponseData::errorResponse(
                $validator->errors()->first());
        }
        $app=AppKey::where("package",$data['package'])->first();
        if(!$app){
            return SdkResponseData::errorResponse("The app {$data['package']} is not exist!");
        }

        $record = CrawlRecord::find($data["task_id"]);
        if ($record->appKey_id != $app->id) {
            return SdkResponseData::errorResponse("Illegal operation");
        }

        $record->state = $data['state'];
        if (isset($data['msg'])) {
            $record->msg = $data['msg'];
        }
        $record->save();
        return SdkResponseData::okResponse();
    }

}
