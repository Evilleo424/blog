<?php

namespace App;

use App\Model;

class Fan extends Model
{
    /**
     * 粉丝
     */
    public function fuser(){
        return $this->hasOne(\App\User::class,'id','fan_id');
    }

    /**
     * 关注
     */
    public function suser(){
        return $this->hasOne(\App\User::class,'id','star_id');
    }
}
