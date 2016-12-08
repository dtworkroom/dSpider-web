<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppKey extends Model
{
    public function spiderConfigs(){
        return $this->hasMany('App\SpiderConfig',"appKey_id");
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
