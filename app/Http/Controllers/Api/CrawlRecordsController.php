<?php

namespace App\Http\Controllers\Api;

use App\Common\ResponseData;
use App\CrawlRecord;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\SpiderConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrawlRecordsController extends Controller
{
    //上报爬取结果
    public function reportState(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required|Numeric',
            'state' => 'required|Numeric',
            "appkey" => 'required|Numeric',
        ]);
        if ($validator->fails()) {
            return ResponseData::errorResponse(
                $validator->errors()->first());
        }

        $record = CrawlRecord::find($data["id"]);
        if ($record->appKey_id != $data["appkey"]) {
            return ResponseData::errorResponse("Illegal operation");
        }

        $record->state = $data['state'];
        if ($data['msg']) {
            $record->msg = $data['msg'];
        }
        $record->save();

        //该spider调用次数自增
        $config = SpiderConfig::where([
            ["spider_id", $record->spider_id],
            ["appKey_id", $record->appKey_id]
        ])->first();
        $config->callCount = $config->callCount + 1;
        $config->save();
        return ResponseData::okResponse();
    }

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

        $page = $request->input("page", 1) - 1;
        $pageCount = $request->input("pageCount", 20);
        $records = CrawlRecord::where($conditions)->whereIn('appKey_id', $appkeys)
            ->skip($page * $pageCount)->take($pageCount)->get();
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

}
