<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 19:44
 */

namespace App\Admin\Controllers;

use App\Post;
use App\Topic;

class TopicController extends Controller{

    public function index(){
        $topics = Topic::paginate(10);
        return view('admin.topic.index',compact('topics'));
    }

    public function create(){
        return view('admin.topic.create');
    }

    public function store(){
        $this->validate(request(),[
            'name'  => 'required|string|min:3',
        ]);

        Topic::create(['name' => request('name')]);
        return redirect('/admin/topics');

    }

    public function destroy(Topic $topic){
        $topic->delete();
        return [
            'error' => 0,
            'msg'   => ''
        ];
    }
}