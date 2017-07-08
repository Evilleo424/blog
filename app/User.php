<?php

namespace App;

use App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	protected $fillable = [
		'name','email','password'
	];

    //用户文章
    public function posts(){
        return $this->hasMany(\App\Post::class,'user_id','id');
    }

    //关注我的
    public function fans(){
        return $this->hasMany(\App\Fan::class,'star_id','id');
    }

    //我关注的
    public function stars(){
        return $this->hasMany(\App\Fan::class,'fan_id','id');
    }

    //关注某人
    public function doFan($uid){
        $fan = new \App\Fan();
        $fan->star_id = $uid;
        return $this->stars()->save($fan);
    }

    //取消关注
    public function doUnFan($uid){
        $fan = new \App\Fan();
        $fan->star_id = $uid;
        return $this->stars()->delete($fan);
    }

    //是否被某人关注

    public function hasFan($uid){
        return $this->fans()->where('fan_id',$uid)->count();
    }

    //是否关注了某人
    public function hasStar($uid){
        return $this->stars()->where('star_id',$uid)->count();
    }

    //用户收到的通知
    public function notices(){
        return $this->belongsToMany(Notice::class,'user_notice','user_id','notice_id')->withPivot(['user_id', 'notice_id']);
    }

    //给用户增加通知
    public function addNotice($notice){
        return $this->notices()->save($notice);
    }
	public function deleteNotice($notice)
	{
		return $this->notices()->detach($notice);
	}


	public function getAvatarAttribute($value)
	{
		if (empty($value)) {
			return '/storage/231c7829cbd325d978898cec389b3f65/egwV7WNPQMSPgMe7WmtjRN7bGKcD0vBAmpRrpLlI.jpeg';
		}
		return $value;
	}
}
