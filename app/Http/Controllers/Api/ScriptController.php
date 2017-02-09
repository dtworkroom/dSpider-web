<?php

namespace App\Http\Controllers\Api;

use App\Common\ResponseData;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Script;
use App\Spider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScriptController extends Controller
{

    public function save(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'spider_id' => 'required',
            'priority'=>"required|Numeric"
        ]);
        if ($validator->fails()) {
            return ResponseData::errorResponse($validator->errors()->first());
        }
        $spider=Spider::find($data['spider_id']);
        if (!($spider&&$request->user()->id==$spider->user_id)) {
           return ResponseData::errorResponse("No permission for this operation !");
        }
        unset($data['size']);
        unset($data['spider']);
        $data["online"] = $data["online"] == "false" ? false : true;
        if (isset($data['id'])) {
            $script = Script::find($data['id']);
        } else {
            $script = new Script();
        }

        foreach ($data as $key => $value) {
            $script->$key = $value;
        }
        $script->save();
        return ResponseData::okResponse($script->id);

    }

    public function delete(Request $request, $id)
    {
        $script = Script::find($id);
        $spider=$script->spider;
        if (!($spider&&$request->user()->id==$spider->user_id)) {
            return ResponseData::errorResponse("No permission for this operation  !");
        }
        $script->delete();
        return ResponseData::okResponse($script->id);
    }


    public function getById(Request $request, $id)
    {
        $script = Script::find($id);
        if (!$script) {
            return ResponseData::errorResponse("Incorrect id!");
        }
        $spider=$script->spider;

        //该脚本作者不是当前用户时鉴权
        if (!($request->user() && $request->user()->id==$spider->user_id)) {
            if(!$spider->public){
                return ResponseData::errorResponse("No permission for this spider!");
            }
            if (!($spider->access & Spider::ACCESS_READ)) {
                unset($script->content);
            }
        }
        $script->size = strlen($script->content);
        return ResponseData::okResponse($script);
    }


}
