<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PostController@index');

//文章列表页
Route::get('/posts', 'PostController@index');


    Route::get('excel/export', 'ExcelController@export');
    Route::get('excel/import', 'ExcelController@import');


//文章模块
    Route::group(['prefix' => 'posts','middleware' => 'before'], function () {
        //创建
        Route::get('/create', 'PostController@create');
        //详情页
	Route::get("/{post}", 'PostController@show');
        //保存
        Route::post('/', 'PostController@store');
        //编辑
        Route::get('/{post}/edit', 'PostController@edit');
        //更新
        Route::put('/{post}', 'PostController@update');
        //删除
        Route::get('/{post}/delete', 'PostController@delete');
        //图片上传
        Route::post('/image/upload', 'PostController@imageUpload');

        //评论
        Route::post('/{post}/comment', 'PostController@comment');

        Route::get('/{post}/zan', 'PostController@zan');
        Route::get('/{post}/unzan', 'PostController@unzan');
    });

//用户模块
//注册页面
    Route::get('/register', 'RegisterController@index');
    Route::post('/register', 'RegisterController@register');
//登录
    Route::get('/login', 'LoginController@index');
    Route::post('/login', 'LoginController@login');
//登出
    Route::get('/logout', 'LoginController@logout');

    Route::group(['prefix' => 'user','middleware' => 'before'], function () {
        Route::get('/me/setting', 'UserController@setting');
        Route::post('/{user}/setting', 'UserController@settingStore');

        Route::get('/{user}', 'UserController@show');
        Route::post('/{user}/fan', 'UserController@fan');
        Route::post('/{user}/unFan', 'UserController@unFan');
    });


//专题
//详情页
Route::group(['middleware' => 'before'], function () {
	Route::get('/topic/{topic}', 'TopicController@show');
	Route::post('/topic/{topic}/submit', 'TopicController@submit');

	Route::get('notices', 'NoticeController@index');
});



Route::group(['prefix' => 'admin'],function() {
    Route::get('/login', '\App\Admin\Controllers\LoginController@index');
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');


    Route::group(['middleware' => 'auth:admin'],function(){
        Route::get('/home','\App\Admin\Controllers\HomeController@index');

        Route::group(['middleware' => 'can:system'],function(){
            Route::get('/users','\App\Admin\Controllers\UserController@index');
            Route::get('/users/create','\App\Admin\Controllers\UserController@create');
            Route::post('/users/store','\App\Admin\Controllers\UserController@store');
            Route::get('/users/{user}/role','\App\Admin\Controllers\UserController@role');//用户角色关联页面
            Route::post('/users/{user}/role','\App\Admin\Controllers\UserController@storeRole');//用户角色关联操作

            //角色
            Route::get('/roles','\App\Admin\Controllers\RoleController@index');
            Route::get('/roles/create','\App\Admin\Controllers\RoleController@create');
            Route::post('/roles/store','\App\Admin\Controllers\RoleController@store');
            Route::get('/roles/{role}/permission','\App\Admin\Controllers\RoleController@permission');//角色权限关联页面
            Route::post('/roles/{role}/permission','\App\Admin\Controllers\RoleController@storePermission');//角色权限关联操作

            //权限
            Route::get('/permissions','\App\Admin\Controllers\PermissionController@index');
            Route::get('/permissions/create','\App\Admin\Controllers\PermissionController@create');
            Route::post('/permissions/store','\App\Admin\Controllers\PermissionController@store');
        });

        Route::group(['middleware' => 'can:post'],function() {
            //审核
            Route::get('/posts', '\App\Admin\Controllers\PostController@index');
            Route::post('/posts/{post}/status', '\App\Admin\Controllers\PostController@status');
        });

        Route::group(['middleware' => 'can:topic'],function() {
            Route::resource('topics','\App\Admin\Controllers\TopicController',['only' => ['index','create','store', 'destroy']]);
        });

        Route::group(['middleware' => 'can:notice'],function() {
            Route::resource('notices','\App\Admin\Controllers\NoticeController',['only' => ['index','create','store']]);
        });

    });

});


























