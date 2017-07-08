<?php
/**
 * Created by PhpStorm.
 * User: linleosm@126.com
 * Date: 2017/7/6
 * Time: 上午12:34
 */
namespace App\Admin\Controllers;


class HomeController extends Controller{

	public function index(){
		return view('admin.home.index');
	}


}