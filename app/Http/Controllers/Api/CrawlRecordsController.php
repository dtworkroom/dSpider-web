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
            $conditions[] = [$key, $value];
        }
        $user = $request->user();
        $appkeys = array_map(function ($item) {
            return $item['id'];
        }, $user->appKeys->toArray());

        $records = CrawlRecord::where($conditions)
            ->where('crawl_records.state','>=' ,'0')
            ->whereIn('appKey_id', $appkeys)
            ->select("crawl_records.id","crawl_records.appKey_id","crawl_records.spider_id","crawl_records.state",
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
            return $item['user_id'];
        }, $user->spiders->toArray());
        $state=$request->input("state",1000);
        $records= DB::table('crawl_records')
            ->where("spider_id", $request->id)
            ->where('crawl_records.state',$state==1000?'>=':"=" ,$state==1000?0:$state)
            ->whereIn('spider_id', $spiders)
            ->leftJoin('app_keys', 'appKey_id', '=', 'app_keys.id')
            ->select("crawl_records.id","crawl_records.appKey_id","crawl_records.spider_id","crawl_records.state",
                "crawl_records.app_version","crawl_records.sdk_version","crawl_records.device_id","crawl_records.updated_at","app_keys.name")
            ->orderBy('updated_at', 'desc')
            ->paginate($request->input("pageSize", 20));

        if ($records) {
             $records= json_decode(json_encode($records));
             $records->app_count=CrawlRecord::distinct("spider_id")->count("spider_id");
             return ResponseData::okResponse($records);
        }
        return ResponseData::errorResponse("Incorrect Request",404);
    }

}
