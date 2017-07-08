<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function setting(){
	    $me = Auth::user();
        return view('user.setting',compact('me'));
    }

    public function settingStore(Request $request,User $user){
	    $this->validate(request(),[
		    'name' => 'min:3',
	    ]);

	    $name = request('name');
	    if ($name != $user->name) {
		    if(\App\User::where('name', $name)->count() > 0) {
			    return back()->withErrors(array('message' => '用户名称已经被注册'));
		    }
		    $user->name = request('name');
	    }
	    if ($request->file('avatar')) {
		    $path = $request->file('avatar')->storePublicly(md5(\Auth::id() . time()));
		    $user->avatar = "/storage/". $path;
	    }

	    $user->save();
	    return back();
    }

    public function show(User $user){
        //个人信息 关注 粉丝 文章数
        $user = User::withCount(['stars','fans','posts'])->find($user->id);
        //文章列表
        $posts = $user->posts()->orderBy('created_at','desc')->skip(0)->take(10)->get();

        //关注用户 包含关注用户的 关注 粉丝 文章数
        $stars = $user->stars;
        $susers = User::whereIn('id',$stars->pluck('star_id'))->withCount(['stars','fans','posts'])->get();

        //关注这个人的用户 包含粉丝的 关注 粉丝 文章数
        $fans = $user->fans;
        $fusers = User::whereIn('id',$fans->pluck('fan_id'))->withCount(['stars','fans','posts'])->get();

        return view('user.show',compact(['user','posts','fusers','susers']));
    }

    public function fan(User $user){
        $me = Auth::user();

        $me->doFan($user->id);
        return [
            'error' => 0,
            'msg'   => ''
        ];
    }

    public function unFan(User $user){
        $me = Auth::user();
        $me->doUnFan($user->id);
        return [
            'error' => 0,
            'msg'   => ''
        ];
    }
}
