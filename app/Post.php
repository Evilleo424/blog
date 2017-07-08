<?php

namespace App;

use App\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
	/**
	 * 关联用户
	 */
	public function user(){
		return $this->belongsTo('App\User');
	}


    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('created_at','desc');
    }


    public function zan($user_id){
        return $this->hasOne(\App\Zan::class)->where('user_id',$user_id);
    }

    public function zans(){
        return $this->hasMany(\App\Zan::class);
    }

	//属于某个作者的文章
	public function scopeAuthorBy(Builder $query,$user_id){
		return $query->where('user_id',$user_id);
	}

	public function postTopics(){
		return $this->hasMany(PostTopic::class,'post_id','id');
	}

	//不属于某个专题的文章
	public function scopeTopicNotBy(Builder $query,$topic_id){
		return $query->doesntHave('postTopics','and',function($q) use ($topic_id){
			$q->where('topic_id',$topic_id);
		});
	}

    //全局scope
    public static function boot(){
        parent::boot();
        static::addGlobalScope('avaiable',function(Builder $builder){
            $builder->whereIn('status',[0,1]);
        });
    }
}
