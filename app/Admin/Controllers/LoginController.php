<?php
/**
 * Created by PhpStorm.
 * User: linleosm@126.com
 * Date: 2017/7/6
 * Time: 上午12:26
 */
namespace App\Admin\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller{

	public function index(){
		return view('admin.login.index');
	}

	public function login(){
        $this->validate(request(),[
            'name'         => 'required|min:2',
            'password'      => 'required|min:5|max:10',
        ]);


        $user = request(['name','password']);
        if(Auth::guard('admin')->attempt($user)){
            return redirect('/admin/home');
        }
        return Redirect::back()->withError('账号密码不匹配');
	}

	public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
	}

    public function welcome(){
        return redirect('welcome');
    }

}