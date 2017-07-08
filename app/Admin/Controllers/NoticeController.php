<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 20:21
 */
namespace App\Admin\Controllers;

use App\Notice;

class NoticeController extends Controller{

    public function index(){
        $notices = Notice::paginate(10);
        return view('admin.notice.index',compact('notices'));
    }

    public function create(){
        return view('admin.notice.create');
    }

    public function store(){
        $this->validate(request(),[
            'title'     => 'required|string|min:3',
            'content'   => ' required|string'
        ]);

        $notice = Notice::create(['title' => request('title'),'content' => request('content')]);

        dispatch(new \App\Jobs\SendMessage($notice));
        return redirect('/admin/notices');
    }


}