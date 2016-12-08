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

    public function author(){
        return $this->hasOne('App\User');
    }
}
