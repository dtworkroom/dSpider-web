<?php

namespace App\Http\Controllers\Api;

use App\Common\ResponseData;
use App\CrawlRecord;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\SpiderConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CrawlRecordsController extends Controller
{


    //获取
    public function getCrawlRecords(Request $request)
    {
        $data = $request->all();
        $conditions = [];
        foreach ($data as $key => $value) {
            if(strpos($key, "page") === 0){
                continue;
            }
            if($key=="state"){
                $state=$value;
                $re=">=";
                $t=0;
                if($state==0){
                    $re="=";
                    $t=0;
                }elseif($state==1){
                    $t=1;
                }
                $conditions[] = [$key,$re, $t];
            }else {
                $conditions[] = [$key, $value];
            }
        }
        $user = $request->user();
        $appkeys = array_map(function ($item) {
            return $item['id'];
        }, $user->appKeys->toArray());

        $records = CrawlRecord::where($conditions)
            ->where('crawl_records.state','>=' ,'0')
            ->whereIn('appKey_id', $appkeys)
            ->select("crawl_records.id","crawl_records.appKey_id","crawl_records.spider_id","crawl_records.os_type","crawl_records.state",
                "crawl_records.app_version","crawl_records.sdk_version","crawl_records.device_id","crawl_records.updated_at")
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input("pageSize", 20));
        $records->setPath($request->fullUrl());

        return ResponseData::okResponse($records);
    }

    public function getCrawlRecordById(Request $request)
    {
        $user = $request->user();
        $appkeys = array_map(function ($item) {
            return $item['id'];
        }, $user->appKeys->toArray());
        $record = CrawlRecord::where("id", $request->id)->whereIn('appKey_id', $appkeys)->first();
        if ($record) {
            return ResponseData::okResponse($record);
        }
        return ResponseData::errorResponse("Incorrect Id");
    }

    public function getCrawlRecordBySpiderId(Request $request)
    {
        $user = $request->user();
        $spiders = array_map(function ($item) {
            return $item->id;
        }, $user->spiders->all());
        $state=$request->input("state",1000);
        $re=">=";
        $t=0;
        if($state==0){
            $re="=";
            $t=0;
        }elseif($state==1){
            $t=1;
        }
        $records= DB::table('crawl_records')
            ->where("spider_id", $request->id)
            ->where('crawl_records.state',$re ,$t)
            ->whereIn('spider_id', $spiders)
            ->leftJoin('app_keys', 'appKey_id', '=', 'app_keys.id')
            ->select("crawl_records.id","crawl_records.appKey_id","crawl_records.spider_id","crawl_records.os_type","crawl_records.state",
                "crawl_records.app_version","crawl_records.sdk_version","crawl_records.device_id","crawl_records.updated_at","app_keys.name")
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input("pageSize", 20));

        if ($records) {
             $records= json_decode(json_encode($records));
             $records->app_count=SpiderConfig::where("spider_id",$request->id)->count();
             return ResponseData::okResponse($records);
        }
        return ResponseData::errorResponse("Incorrect Request",404);
    }

}
