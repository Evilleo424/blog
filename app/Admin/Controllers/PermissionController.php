<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 15:48
 */
namespace App\Admin\Controllers;


use App\AdminPermission;

class PermissionController extends Controller{

    public function index(){
        $permissions = AdminPermission::paginate(10);
        return view('admin.permission.index',compact('permissions'));
    }

    public function create(){
        return view('admin.permission.add');
    }

    public function store(){
        $this->validate(request(),[
            'name'          => 'required|min:3',
            'description'   => 'required'
        ]);
        AdminPermission::create(request(['name','description']));

        return redirect('/admin/permissions');
    }
}

