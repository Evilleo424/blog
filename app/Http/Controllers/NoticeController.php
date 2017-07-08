<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 20:21
 */
namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller{

    public function index(){
        $user = Auth::user();

        $notices = $user->notices;
        return view('notice.index',compact('notices'));
    }
}