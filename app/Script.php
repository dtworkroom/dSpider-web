<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    public function spider(){
        return $this->belongsTo('App\Spider');
    }
}
