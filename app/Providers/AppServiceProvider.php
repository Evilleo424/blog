<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     *///所有服务提供者加载之后进行注册
    public function boot()
    {
        //mb4string 767/4
		Schema::defaultStringLength(191);
        \View::composer('layout.sidebar',function($view){
            $topics = \App\Topic::all();
            $view->with('topics',$topics);
        });

        \DB::listen(function($query){
            $sql = $query->sql;
            $bindings = $query->bindings;
            $time = $query->time;
            \Log::debug(var_export(compact('sql','bindings','time'),true));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    //所有服务提供者加载之前进行注册
    public function register()
    {
        //
    }
}
