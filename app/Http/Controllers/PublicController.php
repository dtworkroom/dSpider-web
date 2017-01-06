<?php

namespace App\Http\Controllers;

use App\CrawlRecord;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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

}
