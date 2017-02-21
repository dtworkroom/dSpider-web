<?php
/**
 * Created by PhpStorm.
 * User: du
 * Date: 16/11/29
 * Time: 下午5:59
 */

namespace App\Common;
use Illuminate\Http\Response;

class ResponseData
{
    const  ERROR_NEED_LOGIN=-10;
    const  ERROR_NO_PERMISSION=-9;
    const  ERROR=-1;
    public $code=0;
    public $data="";
    public $msg="";
    public static function errorResponse($msg="",$data="",$code=-1){
        return self::toJson($code,$data,$msg);
    }
    public static function okResponse($data=""){
        return self::toJson(0,$data,"");
    }
    public static function toJson($code=0,$data="",$msg=""){
        return response()->json($data);
      //return response()->json(new static($code,$data,$msg));
    }

    function __construct($code=0,$data="",$msg="")
    {
        $this->data=$data;
        $this->code=$code;
        if(!$msg) {
            if($code==static::ERROR_NEED_LOGIN){
                $msg="Need log in!";
            }elseif($code!=0){
               $msg="Error";
            }else{
                $msg="Ok";
            }
        }

        $this->msg=$msg;
    }

  function __toString(){
      return json_encode($this);
  }
}