<?php
/**
 * Created by PhpStorm.
 * User: linleosm@126.com
 * Date: 2017/7/8
 * Time: 下午4:23
 */
namespace App\Http\Middleware;

use Closure;

class Before
{
	public function handle($request, Closure $next)
	{
		// 执行动作

		if(\Auth::check()){
			return $next($request);
		}else{
			return redirect('/login');
		}

	}
}
