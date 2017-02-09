<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spider extends Model
{
    const ACCESS_DISPATCH=1;
    const ACCESS_READ=1<<1;

    const SUPPORT_ANDROID=1;
    const SUPPORT_IOS=1<<1;
    const SUPPORT_PC=1<<2;

    const UA_MOBILE=1;
    const UA_PC=2;
    const UA_AUTO=3;

    public function author(){
        return $this->hasOne('App\User');
    }

    public function scripts()
    {
        return $this->hasMany('App\Script');
    }
}
