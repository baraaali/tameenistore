<?php

namespace App\Providers;

use App\UserNotification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
         Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('app.env') != 'production')
        {
            $this->display_errors();
        }
        if (!$this->app->isLocal()) {
            $this->app['request']->server->set('HTTPS', true);
        }
        view()->composer('layouts.app', function ($view) {
            
            $data = [];
            if(auth()->user())
            {
                $data['notifications'] =  UserNotification::where('user_id',auth()->user()->id)->get();
                $data['notifications_count'] =  UserNotification::where([['user_id','=',auth()->user()->id],['viewed','=','0']])->get()->count();
            }
            $data['settings'] = \App\Website::where('id',1)->first();
            $view->with($data);
        });
    


        view()->composer('partials.header', function ($view) {
            $view->with([
                'selected_country'=>  session()->get('selected_value')
            ]);
        });

        App::setlocale('ar');

       /* if(strpos(request()->getPathInfo(),'en') !== false)
        App::setlocale('en');
        else if(strpos(request()->getPathInfo(),'ar') !== false)
        App::setlocale('ar');
        else
        App::setlocale('ar');*/

    }

    public function display_errors()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        ini_set('memory_limit', '640M');
    }
}
