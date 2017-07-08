<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 13:18
 */

namespace App\Admin\Controllers;

use App\AdminRole;
use App\AdminUser;

class UserController extends Controller{

    public function index(){
        $users = AdminUser::paginate(10);
        return view('admin.user.index',compact('users'));
    }

    public function create(){
        return view('admin.user.create');
    }

    public function store(){
        $this->validate(request(),[
            'name'      => 'required|min:3|unique:admin_users,name',
            'password'  => 'required|min:5|max:10'
        ]);

        $name = request('name');
        $password = bcrypt(request('password'));
        AdminUser::create(compact('name','password'));
        return redirect('/admin/users');
    }

    public function role(AdminUser $user){
        $roles = AdminRole::all();
        $myRoles = $user->roles;
        return view('admin.user.role',compact('roles','myRoles','user'));
    }


    public function storeRole(AdminUser $user){
        $this->validate(request(),[
            'roles' =>'required|array'
        ]);
        $roles = AdminRole::findMany(request('roles'));
        $myRoles = $user->roles;

        //要增加的角色
        $addRoles = $roles->diff($myRoles);
        foreach($addRoles as $role){
            $user->assignRole($role);
        }

        //要删除的
        $deleteRoles = $myRoles->diff($roles);
        foreach($deleteRoles as $role){
            $user->deleteRole($role);
        }

        return back();
    }


}