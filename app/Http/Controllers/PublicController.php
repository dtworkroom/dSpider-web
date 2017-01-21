<?php

namespace App\Http\Controllers;

use App\CrawlRecord;
use App\Download;
use App\Spider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function pn(...$arg){
        foreach($arg as $a){
            echo $a."<br>";
        }
    }

    public function spider(Request $request, $id){
        $controller=new Api\SpiderController;
        $ret=json_decode($controller->getById($request,$id)->getContent());
        if($ret->code!=0){
           // throw new ModelNotFoundException ;
            return view('errors.404');
        }
       return view("spider",["spider"=>$ret->data,"title"=>$ret->data->name]);

    }
    public function record(Request $request, $id){
        $record=CrawlRecord::find($id);
        if(!$record){
            return view('errors.404');
        }
        $app=$record->appKey;
        $spider=$record->spider;
        $uid=$request->user()->id;

        //爬取记录只有app用户和脚本作者可见
        if($app->user_id!=$uid&&$spider->user_id!=$uid){
            return view('errors.deny');
        }

        $spider=$record->spider;
        $device=$record->device;
        $title="爬取记录#".$record->id;
        return view("profile.record",compact('record','app','spider','device','title'));

    }

    public function getRecordsBySpiderId(Request $request,$id){
        return view('profile.spider-records',qs(['id'=>$id,'name'=>$request->name]));
    }

    public function doc($id="js_api"){
        $path=(public_path()."/docs/".$id.".md");
        $time=date("Y-m-d H:i:s",filemtime($path));
        $content= file_get_contents($path);
        return view('doc',compact('id','time','content'));
    }
    public function downloadDoc($id){
        $path=(public_path()."/docs/".$id.".md");
        $time=date("Ymd",filemtime($path));
        return response()->download($path,$time.'_'.$id.".md");
    }
    public function store(){

       //var_dump(DB::table("spiders")->select(DB::raw('category'))->groupBy("category")->get());
        $all=[];
//        $items=DB::select("select * from spiders a where (select count(*) from spiders b where a.category=b.category and a.id<b.id )<12 order by category asc, id asc");
//        array_map(function($item) use(&$categories){
//            $categories[getCategories($item->category)][]=$item;
//            return $item;
//        },$items);
//
        Spider::all()->map(function($item) use(&$all){

            $path=public_path()."/img/icon/".$item->id;
            if(file_exists($path)) {
                $item->icon=$item->id;
            }else{
                $item->icon="default.png";
            }
            $all[getCategories($item->category)][]=$item;
            return $item;
        });
        $categories=[];
        foreach(getCategoryOrder() as $category){
            if(isset($all[$category])){
                $categories[$category]=$all[$category];
            }
        }
        return view("store",compact('categories'));


    }
    public function downloadWithStatistic($id){
        $map=["sdk-android"=>1,"sdk-ios"=>2,"pc-tool"=>3];
        if(isset($map[$id])){
            $download=Download::find($map[$id]);
            if(!$download){
                $download=new Download();
            }
            $download->id=$map[$id];
            $download->count++;
            $download->save();
            $path=(public_path()."/open/".$id.".zip");
            if(file_exists($path)) {
                $time=date("Ymd",filemtime($path));
                return response()->download($path, $time . '-' . $id . ".zip");
            }
        }
        return view("errors.404");
     }

    }
