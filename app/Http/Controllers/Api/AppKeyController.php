<?php
/**
 * Created by PhpStorm.
 * User: du
 * Date: 17/1/6
 * Time: 下午8:31
 */

namespace App\Http\Controllers\Api;
use App\AppKey;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Common\ResponseData;
use App\SpiderConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class AppKeyController extends Controller
{
    public function index(Request $request)
    {
        return ResponseData::okResponse(AppKey::all());
    }
    public function getAllByUser(Request $request)
    {
        return ResponseData::okResponse($request->user()->appKeys);
    }
    public function save(Request $request)
    {
        $data = $request->all();
        if (!isset($data["secret"])) {
            $data["secret"] =getRandChar(32);
        }
        $validator = Validator::make($data, [
            'package' => 'required|min:4|max:255',
            'name'=>'required|max:255',
            'secret' => 'min:6|max:255',
        ]);
        if ($validator->fails()) {
            return ResponseData::errorResponse($validator->errors()->first());
        }
        if (isset($data["id"])) {
            $appKey = AppKey::find($data["id"]);
            if($appKey->user_id!=$request->user()->id){
                return ResponseData::errorResponse("No permission!");
            }
        } else {
            $appKey = new AppKey();
            //每一个新的Appkey默认授权测试脚本
            $config=new SpiderConfig();
            $config->spider_id=1;
        }
        $appKey->secret = $data["secret"];
        $appKey->user_id = $request->user()->id;
        $appKey->name=$data["name"];
        $appKey->package=$data['package'];
        $appKey->save();
        if(isset($config)){
            $config->appKey_id=$appKey->id;
            $config->save();
        }
        return ResponseData::okResponse($appKey->id);
    }
    public function delete(Request $request, $id)
    {
        $appkey = AppKey::find($id);
        if($appkey->user_id!=$request->user()->id){
            return ResponseData::errorResponse("No permission !");
        }
        $appkey->delete();
        return ResponseData::okResponse($appkey->id);
    }
    public function getById(Request $request, $id)
    {
        $appkey = AppKey::find($id);
        $configs= DB::table('spider_configs')
            ->where("appKey_id", $request->id)
            ->leftJoin('spiders', 'spider_id', '=', 'spiders.id')
            ->select("spider_configs.*","spiders.name")
            ->get();
        return ResponseData::okResponse(["appkey"=>$appkey,"configs"=>$configs]);
    }
    public function getConfigs(Request $request,$id)
    {
        $configs= DB::table('spider_configs')
            ->where("appKey_id", $request->id)
            ->leftJoin('spiders', 'spider_id', '=', 'spiders.id')
            ->select("spider_configs.*","spiders.name")
            ->get();
        return ResponseData::okResponse($configs);
    }
}