<?php

use App\Cars;
use App\country;
use App\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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

//////////////
Route::get('/migrate',function(){
   // Artisan::call('migrate');
    Artisan::call('config:clear');
    die('done');
});


//user notifications
Route::resource('dashboard/user-notifications','UserNotificationController');
Route::post('user-notifications/store-auto-notification','UserNotificationController@storeAutoNotification')->name('user-notifications.store-auto-notification');
Route::get('dashboard/send-notification','UserNotificationController@sendNotification')->name('user-notifications.send');
Route::get('dashboard/promotion-notifications','UserNotificationController@promotionNotification')->name('promotion-notifications');
Route::post('dashboard/get-user-count','UserNotificationController@getUserCount')->name('user-notifications.get-user-count');
Route::post('dashboard/send-notification','UserNotificationController@sendNotification')->name('user-notifications.post-send');


Route::get('/dashboard/site/settings/myfatoorah',function (){
    $site=\App\Website::first();
    $site->token=strip_tags(preg_replace('/\s+/', '', $site->token));

    return view('myfatoorah',compact('site'));
});
Route::post('/user-auth/login','SecurityController@user_login')->name('custom-user-route');
Route::get('/user-forget-password/{lang?}',function($lang = null){

    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }

    return view('auth.verify');

});

Route::post('/custom-email-user/{lang?}',function(Request $request,$lang=null) {
    $request->validate([
        'email' => 'required',
    ]);

    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    $user = \App\User::where('email',$request->email)->first();

    if($user) {
        $code = rand(1000,9999);
        Mail::send([], [], function($message) use ($user,$code) {

            $message->to($user->email, 'Reset Your Password')->subject
            ('New Reset Password Code')// here comes what you want
            ->setBody('<h4> Hello, ' . $user->name  . ' , </h4> <p> Your Reset Code is <span style="color:#ff5b5c" >'. $code .'</span> ! </p>', 'text/html'); // assuming text/plain
            $message->from('info@tameenistore.com','Customer Services');
        });

        $user->remember_token = $code;
        $user->save();
        return view('auth.codeType')->with('email',$request->email);

    } else {
        return back();
    }

})->name('custom-email-user');
Route::get('/forget-country',function (){
   return forgetCountry();
})->name('forget-country');
Route::post('/custon-code-user/{lang?}',function(Request $request, $lang=null) {
    $request->validate([
        'email' => 'required',
        'code'=>'required',
    ]);

    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    $user = \App\User::where(['email'=>$request->email,'remember_token'=>$request->code])->first();
    if($user) {
        return view('auth.newPassword')->with('id',$user->id);
    } else {
        return 'invalid Code';
    }
})->name('custom-code-user');

Route::post('/user-change-password/{lang?}' ,function(Request $request, $lang =null) {
    $request->validate([
        'password'=>'required',
        'id' => 'required',
    ]);

    $user = \App\User::where('id',$request->id)->first();

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect('/user/login/'.$lang);


})->name('user-change-password');
Route::get('/view/usage/{lang?}',function($lang = null){

    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('content.usage')->with('lang',$lang);
});
Route::get('/view/termsandcondition/{lang?}',function($lang = null){

    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('content.terms')->with('lang',$lang);
});
Route::get('/view/maintainces/{lang?}',function($lang = null){

    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('content.mcenter');
})->name('maintaince-centers');
Route::post('/user/upload-documents','SecurityController@uploadUserDocuments')->name('upload-user-documents');

Route::get('/country/{country}/{lang?}','FrontEndController@SpecificCountry');
Route::get('/view/ads/{lang?}','SearchController@index')->name('ads');
Route::get('/view/ad/{id?}/{lang?}','SearchController@viewad')->name('view-ad');
Route::get('/ads/type/{type}','SearchController@typesIneed');
Route::post('/ads/notify','SearchController@userNotify')->name('user_notify');

Route::get('/view/selling-agent/{lang?}',function($lang = null){
    $title = 'selling';
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    $brands=\App\brands::where('status',1)->get();
    $agents=\App\Agents::where('agent_type',0);
    $type=0;
    if (getCountry() !=0) $agents=$agents->where('country_id',getCountry());
    $agents=$agents->where('status',1)->orderBy('id','desc')->paginate('10');
    //return view('content.agent')->with(['agents'=>\App\Agents::where('agent_type',0)->orderBy('id','desc')->paginate(5),'title'=>$title]);
    return view('front.all_agency')->with(['lang'=>$lang,'brands'=>$brands,'agents'=>$agents,'title'=>$title,'type'=>$type]);
})->name('selling-agent');
Route::get('/view/slider/{lang?}',function($lang = null){
    return view('slider',compact('lang'));
});
Route::get('/view/leasing-agent/{lang?}','SearchController@leasingAgent')->name('leasing-agent');
Route::post('/view/search/cars_rent/{lang?}','SearchController@searchCarRent')->name('search_cars_rent');
Route::get('/view/exhibitor/{lang?}',function($lang = null){
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('content.exhibitor');
})->name('view-exhibitors');
Route::get('/view/advertisment/{lang?}',function($lang = null){
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('content.advertisment');
});
Route::get('/view/childerns/{id}',function($id){
    return $a=\App\models::where('brand_id',$id)->get();
});
Route::get('/view/get-brands/{id}',function($id){
    return $a=\App\brands::where('vehicle_id',$id)->get();
});
Route::get('/view/get-careshapes/{vehicle_id}/{brand_id}',function($vehicle_id,$brand_id){
    if(!empty($brand_id) && $brand_id != 0) 
    {
        $care_shape_ids = \App\models::where('brand_id',$brand_id)->get()->pluck('care_shape_id');
        return  \App\CareShape::whereIn('id',$care_shape_ids)->get();
    }
    if(!empty($vehicle_id) && $vehicle_id != 0) 
    {
        $brands_ids = \App\brands::where('vehicle_id',$vehicle_id)->get()->pluck('id');
        $care_shape_ids = \App\models::whereIn('brand_id',$brands_ids)->get()->pluck('care_shape_id');
        return  \App\CareShape::whereIn('id',$care_shape_ids)->get();
    }

});

Route::get('/view/childerns_models/{id}',function($id){
    $rows=\App\CompleteDoc::where('brand_id',$id)->pluck('model_id');
    $model=App\models::whereIn('id',$rows)->get();
    return $model;
});
Route::get('/view/models/{id}/{name}',function($id,$name){
    $user_id=auth()->user()->id;
    $ids=\App\CompleteDoc::where(['user_id'=>$user_id,'Insurance_Company_ar'=>$name])->pluck('model_id')->toArray();
//dd($ids);
    return \App\models::where('brand_id',$id)->whereNotIn('id',$ids)->get();
});
Route::get('/view/childerns/models/{id}/{other}',function($id,$other){
    $user_id=auth()->user()->id;
    $ids=\App\InsuranceDocument::where(['user_id'=>$user_id,'other_id'=>$other])->pluck('model_id')->toArray();
//dd($ids);
    return \App\models::where('brand_id',$id)->whereNotIn('id',$ids)->get();
});
Route::get('/get/items/for/users','FrontEndController@user_item');
Route::get('/view/goverment/{id}',function($id){
    return \App\country::where('parent',$id)->get();
});
Route::get('/view/department/{id}',function($id){
    return \App\country::where('parent',$id)->get();
});
Route::get('/join/to/membershib/{id}/{lang?}','ControlPanelController@joinMembership');
Route::get('/cp/index/{lang?}','ControlPanelController@controlPanel')->name('my-home');
//Route::get('/cp/index/{lang?}','ControlPanelController@controlPanel');
Route::post('/update/myinfo','ControlPanelController@updateMyInfo')->name('user-update');
Route::get('/show_balance','ControlPanelController@showBalance')->name('show_balance');


Route::post('/promotion/cities/get-governorates','ControlPanelController@getGovernorates')->name('cities-get-governorates-post');
Route::post('/promotion/cities/','ControlPanelController@getCities')->name('cities-get-post');


Route::get('/promotion','PromotionController@promotion')->name('promotion');
Route::get('/promotion/show/{id}','PromotionController@show')->name('promotion-show');
Route::post('/promotion/update','PromotionController@update')->name('promotion-update');
Route::get('/promotion/destroy/{id}','PromotionController@destroy')->name('promotion-destroy');
Route::get('/promotion/new','PromotionController@promotionNew')->name('promotion-new');
Route::post('/promotion/new','PromotionController@store')->name('promotion-new-post');
Route::post('/promotion/target/count','PromotionController@targetCount')->name('promotion-target-count');

Route::get('/promotion/new','PromotionController@promotionNew')->name('promotion-new');

Route::post('/promotion/add-balance','PromotionController@addBalancePromotion')->name('add-balance-promotion');
Route::post('/promotion/ads','PromotionController@getAdsByType')->name('promotion-get-ads');

//Route::get('payment', 'PaymentController@index');
Route::post('charge', 'PaymentController@charge');
Route::get('paymentsuccess', 'PaymentController@payment_success');
Route::get('paymenterror', 'PaymentController@payment_error');

Route::get('/cp/info/{lang?}',function($lang = null){
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('Cdashboard.index');
});

// mcenter services
Route::get('/cp/mcenter-services/{lang?}','ControlPanelController@mcenterServices');
Route::get('/cp/mcenter-services/show/{id}','ControlPanelController@showMcenterService')->name('mcenter-service-get');
Route::delete('/cp/mcenter-services/delete/{id}','ControlPanelController@deleteMcenterService');
Route::post('/cp/mcenter-services/{lang?}','ControlPanelController@mcenterServices')->name('create-mcenter-service');
Route::post('/cp/mcenter-services/sub/get-additional-services','ControlPanelController@getAdditionalByService')->name('mcenter-get-additional-services');

Route::get('/cp/mcenter-additional-services/{lang?}','ControlPanelController@mcenterAdditionalServices');
Route::get('/cp/mcenter-additional-services/show/{id}','ControlPanelController@showAdditionalMcenterService')->name('mcenter-additional-service-get');
Route::delete('/cp/mcenter-additional-services/delete/{id}','ControlPanelController@deleteMcenterAdditionalService');
Route::post('/cp/mcenter-additional-services/{lang?}','ControlPanelController@mcenterAdditionalServices')->name('create-additional-mcenter-service');


Route::get('/cp/ads/{lang?}','ControlPanelController@adsView');
Route::get('/cp/mcenter-requests/{lang?}','ControlPanelController@mcenterRequests')->name('cp-mcenter-requests');
Route::post('/cp/mcenter-requests/change-status','ControlPanelController@changeStatusMcenterRequests')->name('change-status-mcenter-requests');
Route::get('/cp/notifications/{lang?}/{id?}','ControlPanelController@notificationsView')->name('notifications-view');
Route::post('cp/ads/renew' , 'ControlPanelController@AdRenew');
Route::post('cp/ads/renew' , 'ControlPanelController@AdRenew');
Route::post('cp/contact-us', 'ControlPanelController@contactUs')->name('contact_with_us');
Route::post('cp/incomplete-insurance/renew' , 'ControlPanelController@incInsuranceRenew');
Route::post('cp/complete-insurance/renew' , 'ControlPanelController@CompInsuranceRenew');

Route::get('/show/{dep}/{lang?}',function($dep,$lang = null){
  //  $name = str_replace('_',' ',$dep);
    $category = \App\Categories::where('id',$dep)->first();
    if (!isset($category)) return redirect()->back();
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    $day = date('Y-m-d');
    $items=\App\items::where(['status'=>1,'category_id'=>$category->id])
        ->where('item_end_date','>',$day)
        ->whereHas('user', function($q)
    {$q->where('block',1);})->paginate(15);
    // return view('content.items')->with(['items'=>$items,'lang'=>$lang]);
    return view('content.all_departments')->with(['items'=>$items,'lang'=>$lang,'category_id'=>$category->id]);
});

Route::get('/show/department/{id}/{lang?}','ItemsController@showCat')->name('showCat');
Route::get('/departments/{lang?}','DepartmentController@allDepartments')->name('allDepartments');
Route::post('/departments/{lang?}','DepartmentController@searchDepartment')->name('searchDepartment');

// Route::get('/cp/ads/{lang?}',function($lang = null){
// if($lang == 'ar' || $lang == 'en')
// 	{
// 		App::setlocale($lang);
// 	}
// 	else
// 	{
// 		App::setlocale('ar');
// 	}
//     return view('Cdashboard.index2');
// });

Route::get('/cp/branches/{lang?}',function($lang = null){
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('Cdashboard.index3')->with('lang',$lang);
});

Route::get('/view/fav/{lang?}',function($lang = null){
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('content.fav');
});
Route::get('/view/compar/{lang?}',function($lang = null){
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('content.compar');
});
Route::get('/view/advertisment/{lang?}',function($lang = null){
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('content.adv');
});



Route::post('/user/store/{lang?}','SecurityController@register')->name('user-store');
Route::get('/migrate',function(){
    Artisan::call('migrate');
    die('done');
});

Route::get('/user/login/{lang?}',function($lang = null){
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('auth.login');
})->name('user-login');

Route::get('/user/register/{lang?}',function($lang = null){
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    $countries = country::where('status',1)->get();
          $categories = ServiceCategory::where('status','1')->get();

    return view('auth.register',compact('countries','categories'));
})->name('user-register');

Route::post('/user/governorates/get-governorates/','UserController@getGovernorates')->name('user-get-governorates');
Route::post('/user/cities/get-cities/','UserController@getCities')->name('user-cities-get');



Route::get('/{lang?}', function ($lang = null) {
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }

    return view('welcome');
})->name('main');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');






/*
* Ahmed Wael Web Developer 01009569092*
* ahmed.wael010166@gmail.com*
* Dashboard Routes .. *
* Secure Routes *
*/


Route::get('/dashboard/secure/login/{lang?}',function ($lang = null){

    Auth::logout();
    if($lang)
    {
        if($lang == 'ar' || $lang == 'en')
        {
            App::setlocale($lang);
        }
        else
        {
            App::setlocale('ar');
        }

    }
    else{
        App::setlocale('ar');
    }
    return view('dashboard.auth.login');
})->name('dashboard');

Route::post('/dashboard/login','SecurityController@login')->name('dashboard-login');

Route::get('/dashboard/index','DashboardController@index')->name('dashboard');


/**
 * Countries ROUTES *

 */
Route::get('/dashboard/countries/index','CountryController@index')->name('countries');
Route::post('/dashboard/countries/index','CountryController@index')->name('countries-post');

Route::get('/dashboard/countries/create','CountryController@create')->name('countries-create');

Route::post('/dashboard/countries/store','CountryController@store')->name('countries-store');

Route::get('/dashboard/countries/edit/{id}','CountryController@edit')->name('countries-edit');

Route::post('/dashboard/countries/update','CountryController@update')->name('countries-update');

Route::get('/dashboard/countries/delete/{id}','CountryController@destroy');

Route::get('/dashboard/countries/restore/{id}','CountryController@restore');

Route::get('/dashboard/countries/force/{id}','CountryController@force');

Route::get('/dashboard/countries/archive','CountryController@archive')->name('countries-archive');

/**
 * END OF CONUTRIES ROUTE*
 **
 **
 */

/**
 * governorates routes
 */

Route::get('/dashboard/governorates/index','GovernorateController@index')->name('governorates');

Route::post('/dashboard/governorates/index','GovernorateController@index')->name('governorates-post');

Route::get('/dashboard/governorates/create','GovernorateController@create')->name('governorates-create');

Route::post('/dashboard/governorates/store','GovernorateController@store')->name('governorates-store');

Route::get('/dashboard/governorates/edit/{id}','GovernorateController@edit')->name('governorates-edit');

Route::post('/dashboard/governorates/update','GovernorateController@update')->name('governorates-update');

Route::get('/dashboard/governorates/delete/{id}','GovernorateController@destroy');

Route::get('/dashboard/governorates/restore/{id}','GovernorateController@restore');

Route::get('/dashboard/governorates/force/{id}','GovernorateController@force');

Route::get('/dashboard/governorates/archive','GovernorateController@archive')->name('governorates-archive');
 /**
 * end governorates routes
 */

 /**
 * cities routes
 */

Route::get('/dashboard/cities/index','CityController@index')->name('cities');

Route::post('/dashboard/cities/index','CityController@index')->name('cities-post');

Route::get('/dashboard/cities/create','CityController@create')->name('cities-create');

Route::post('/dashboard/cities/store','CityController@store')->name('cities-store');

Route::get('/dashboard/cities/edit/{id}','CityController@edit')->name('cities-edit');

Route::post('/dashboard/cities/update','CityController@update')->name('cities-update');

Route::get('/dashboard/cities/delete/{id}','CityController@destroy');

Route::get('/dashboard/cities/restore/{id}','CityController@restore');

Route::get('/dashboard/cities/force/{id}','CityController@force');

Route::get('/dashboard/cities/archive','CityController@archive')->name('cities-archive');

Route::get('/dashboard/cities/get-governorates/{id}','CityController@getGovernorates')->name('cities-get-governorates');
 /**
 * end cities routes
 */

/**
 * Start EXHIBITORS ROUTES *
 **
 **
 */

Route::get('dashboard/exhibitors/index','ExhibitionController@index')->name('exhibitors');

Route::get('dashboard/exhibitors/create','ExhibitionController@create')->name('exhibitors-create');

Route::post('dashboard/exhibitors/store','ExhibitionController@store')->name('exhibitors-store');

Route::get('dashboard/exhibitors/edit/{id}','ExhibitionController@edit')->name('exhibitors-edit');

Route::post('dashboard/exhibitors/update','ExhibitionController@update')->name('exhibitors-update');

Route::get('/dashboard/exhibitors/delete/{id}','ExhibitionController@destroy');

Route::get('/dashboard/exhibitors/restore/{id}','ExhibitionController@restore');

Route::get('/dashboard/exhibitors/force/{id}','ExhibitionController@force');

Route::get('/dashboard/exhibitors/archive','ExhibitionController@archive')->name('exhibitors-archive');


/**
 * End EXHIBITORS ROUTES *
 **
 **
 */


/**
 * Start Agent ROUTES *
 **
 **
 */

Route::get('dashboard/agents/index/{type}','AgentsController@index')->name('agents');

Route::get('dashboard/agents/create','AgentsController@create')->name('agents-create');

Route::post('dashboard/agents/store','AgentsController@store')->name('agents-store');

Route::get('dashboard/agents/edit/{id}','AgentsController@edit')->name('agents-edit');

Route::post('dashboard/agents/updaet','AgentsController@update')->name('agents-update');

Route::get('/dashboard/agents/delete/{id}','AgentsController@destroy')->name('agents-delete');

Route::get('/dashboard/agents/restore/{id}','AgentsController@restore')->name('agents-restore');

Route::get('/dashboard/agents/force/{id}','AgentsController@force')->name('agents-force');

Route::get('/dashboard/agents/archive','AgentsController@archive')->name('agents-archive');
Route::get('/dashboard/agents/agentChangeStatus','AgentsController@agentChangeStatus')->name('agents-archive');



/**
 * end Agent ROUTES *
 **
 **
 */

Route::resource('dashboard/insurnaces','InsurnaceController')->except('show');
Route::get('/dashboard/insurnaces/insurChangeStatus','InsurnaceController@insurChangeStatus')->name('insurChangeStatus');

/**
 * Start Maintaince Center ROUTES *
 **
 **
 */

Route::get('/dashboard/mcenters/index','McentersController@index')->name('centers');
Route::get('/dashboard/mcenters/requests','McentersController@getRequests')->name('centers-request');
Route::post('/dashboard/mcenters/requests','McentersController@getRequests')->name('requests-post');
Route::post('/dashboard/mcenters/renewal','McentersController@renewal')->name('renewal-centers');

Route::post('/dashboard/mcenters/index','McentersController@index')->name('centers-post');


Route::get('dashboard/mcenters/create','McentersController@create')->name('centers-create');

Route::post('dashboard/mcenters/store','McentersController@store')->name('centers-store');

Route::get('dashboard/mcenters/edit/{id}','McentersController@edit')->name('centers-edit');

Route::post('dashboard/mcenters/update','McentersController@update')->name('centers-update');

Route::get('/dashboard/mcenters/delete/{id}','McentersController@destroy')->name('centers-delete');

Route::get('/dashboard/mcenters/restore/{id}','McentersController@restore')->name('centers-restore');

Route::get('/dashboard/mcenters/force/{id}','McentersController@force')->name('centers-force');

Route::get('/dashboard/mcenters/archive','McentersController@archive')->name('centers-archive');
Route::get('/dashboard/mcenters/centerChangeStatus','McentersController@centerChangeStatus')->name('centerChangeStatus');




/**
 * End Maintaince Center ROUTES *
 **
 **
 */



/**

 * CARS START ROUTES*


 */
Route::get('/dashboard/cars/index','CarsController@index')->name('cars');
Route::post('/dashboard/cars/renew-date-ads','CarsController@renewDateAds')->name('dashboard_renew_date_ads');

Route::get('dashboard/Cars/create','CarsController@create')->name('cars-create');

Route::post('dashboard/Cars/store','CarsController@store')->name('cars-store');

Route::get('dashboard/Cars/edit/{id}','CarsController@edit')->name('cars-edit');

Route::post('dashboard/Cars/update','CarsController@update')->name('cars-update');

Route::get('/dashboard/Cars/delete/{id}','CarsController@destroy')->name('cars-delete');

Route::get('/dashboard/Cars/restore/{id}','CarsController@restore')->name('cars-restore');

Route::get('/dashboard/Cars/force/{id}','CarsController@force')->name('cars-force');

Route::get('/dashboard/Cars/archive','CarsController@archive')->name('cars-archive');
Route::get('/dashboard/Cars/carChangeStatus','CarsController@carChangeStatus')->name('carChangeStatus');







/* END OF CARS ROUTES **/


/** START OF MEMBER SHIP ROUTES*/


Route::get('/dashboard/membership/index','MembershipController@index')->name('membership');

Route::get('dashboard/membership/create','MembershipController@create')->name('membership-create');

Route::post('dashboard/membership/store','MembershipController@store')->name('membership-store');

Route::get('dashboard/membership/edit/{id}','MembershipController@edit')->name('membership-edit');

Route::post('dashboard/membership/update','MembershipController@update')->name('membership-update');

Route::get('/dashboard/membership/delete/{id}','MembershipController@destroy')->name('membership-delete');

Route::get('/dashboard/membership/restore/{id}','MembershipController@restore')->name('membership-restore');

Route::get('/dashboard/membership/force/{id}','MembershipController@force')->name('membership-force');

Route::get('/dashboard/membership/archive','MembershipController@archive')->name('membership-archive');







Route::get('/dashboard/users/index','UserController@index')->name('users');
Route::get('/dashboard/users/delet','UserController@index')->name('users');
Route::post('/dashboard/users/renew_member_user','UserController@renewMemberUser')->name('renew_member_user');
Route::get('/dashboard/users/destroy/{id}','UserController@destroy')->name('users-delete');
Route::get('/dashboard/users/unblock/{id}','UserController@un_block')->name('users-unblock');
Route::get('/dashboard/users/restore/{id}','UserController@restore')->name('users-restore');
//Route::resource('dashboard/users','UserController');

Route::get('/dashboard/users/force/{id}','UserController@force')->name('users-force');
Route::get('/dashboard/users/delete/{id}','UserController@force')->name('users-force');
Route::get('/dashboard/users/delete_user/{id}','UserController@delete')->name('users.delete');
Route::get('/dashboard/users/edit_user/{id}','UserController@edit')->name('users.edit');
Route::post('/dashboard/users/update_user','UserController@update')->name('users.update');

Route::get('/dashboard/users/archive','UserController@archive')->name('users-archive');



Route::get('/dashboard/pages/index','PagesController@index')->name('pages');
Route::post('/dashboard/pages/store','PagesController@store')->name('pages-store');
Route::post('/dashboard/pages/update','PagesController@update')->name('pages-update');
Route::get('/dashboard/pages/delete/{id}','PagesController@destroy')->name('pages-delete');
Route::get('/dashboard/pages/restore/{id}','PagesController@restore')->name('pages-restore');
Route::get('/dashboard/pages/archive','PagesController@archive')->name('pages-archive');
Route::get('/dashboard/pages/catChangeStatus','PagesController@catChangeStatus')->name('catChangeStatus');


/**
 *
 * Adding new Departments for pages
 *
 *
 **/

Route::get('/dashboard/departments/{id}','PagesController@departmentIndex')->name('departments');
Route::post('/dashboad/departments/store','PagesController@departmentStore')->name('departments-store');
Route::get('/dashboard/departments/edit/{id}','PagesController@departmentEdit')->name('departments-edit');
Route::post('/dashboard/departments/update','PagesController@departmentUpdate')->name('departments-update');
Route::get('/dashboard/departments/delete/{id}','PagesController@departmentDestroy')->name('departments-delete');
Route::get('/dashboard/departments/resotre/{id}','PagesController@departmentRestore')->name('departments-restore');


/*      Fawzy Add this       */
Route::get('/cp/ads/{lang?}','ControlPanelController@MyAds')->name('my-ads');
Route::get('/cp/ads/create/{lang?}','ControlPanelController@CrAds')->name('Ads-create');
Route::post('/cp/ads/renew/ad/{lang?}','ControlPanelController@renewAdsFromBalance')->name('renew_ads_from_balance');
Route::post('/cp/ads/store','ControlPanelController@Adstore')->name('Ads-store');
Route::get('/cp/ads/edit/{id}/{lang?}','ControlPanelController@Adedit')->name('Ads-edit');
Route::post('/cp/ads/update','ControlPanelController@Adupdate')->name('Ads-update');
Route::get('/cp/ads/delete/{id}','ControlPanelController@Adforce')->name('Ads-delete');

Route::get('/Cdashboard/branches/{lang?}','ControlPanelController@index');

Route::get('exhibitors/edit/{id}/{lang?}','FrontEndController@showDetails')->name('exhibitors-details');

Route::get('agent/content/{id}/{lang?}','FrontEndController@agDetails')->name('agent-details');
Route::post('agent/update','ControlPanelController@updateMyAgnecyInfo')->name('agent-update');
Route::post('mcenter/update','ControlPanelController@updateMcenter')->name('mcenter-update');
Route::post('agent/search/{lang}','AgnecyController@searchAgnecy')->name('search_agency');
Route::get('agency/show/{id}/{lang}','AgnecyController@agency')->name('agency_show');
Route::post('agency/send-request','AgnecyController@booking')->name('booking')->middleware('auth');
Route::get('agency/owner/show-orders/{lang}','AgnecyController@showOrder')->name('my_orders');
Route::get('agency/order/delete/{id}','AgnecyController@deleteOrder')->name('order-delete');
Route::post('cp/exh/store','FrontEndController@branchStore')->name('exhi-store');
Route::post('/cp/exh/update','ControlPanelController@updateMyExhibitorInfo')->name('exhi-update');
Route::get('/cp/exh/delete/{id}','FrontEndController@exforce')->name('exhi-delete');

Route::post('cp/agBranch/store','ControlPanelController@agBranchStore')->name('agBranch-Store');
Route::post('cp/agBranch/update','ControlPanelController@agBranchUpdate')->name('agBranch-Update');
Route::get('cp/agBranch/delete/{id}','ControlPanelController@agforce')->name('agBranch-delete');

Route::post('cp/exBranch/store','ControlPanelController@exBranchStore')->name('exBranch-Store');
Route::post('cp/exBranch/update','ControlPanelController@exBranchUpdate')->name('exBranch-Update');
Route::get('cp/exBranch/delete/{id}','ControlPanelController@exforce')->name('exBranch-delete');


/*     Newwwwwwwwwwwwwwww    Fawzy Add this     15-5-2020 task  */
Route::get('/view/sales/{lang?}','SearchController@sales')->name('sales');
Route::post('/view/search/cars/{lang?}','SearchController@searchCar')->name('search_cars');
Route::post('/view/search/ads/{lang?}','SearchController@searchAds')->name('search_ads');
Route::get('/view/rent/{lang?}','SearchController@rent')->name('rent');
Route::get('/view/mcenters/{lang?}','SearchController@mcenters')->name('mcenters');
Route::post('/view/mcenters/search','SearchController@mcenters')->name('mcenters-search');
Route::get('/view/mcenters/profil/{id}/{lang?}','SearchController@getMcenter')->name('mcenters-profil');
Route::get('/view/mcenters/check-availability/{mcenter_id}/{day}/{delivery_day}','SearchController@checkAvailability')->name('mcenters-check-availability');
Route::post('/view/mcenters/maintenance-request/save','SearchController@saveMaintenanceRequest')->name('save-maintenance-request');

/*     Newwwwwwwwwwwwwwww    Fawzy Add this     21-5-2020 task  */
Route::get('/Cdashboard/insurance/{lang?}','ControlPanelController@index2')->name('Cdashboard-insurance');
Route::get('/Cdashboard/complete/insurance/{lang?}','ControlPanelController@index3')->name('all_complete');
Route::get('/cp/create/{lang?}','ControlPanelController@inDocumentCreate')->name('inDocument-Create');
Route::get('/cp/create/complete/{lang?}','ControlPanelController@inDocumentCreateComplete')->name('inDocument-Create-complete');
Route::post('/cp/save/complete/{lang?}','ControlPanelController@saveCompleteData')->name('Document-save-data');
Route::post('cp/inDocument/store','ControlPanelController@inDocumentStore')->name('inDocument-Store');  //
Route::post('cp/inDocument/store_data','ControlPanelController@generalDocCreateUpdate')->name('inDocument-Store-data');  //
Route::post('cp/inDocument/store_data-brand','ControlPanelController@storeDocBrand')->name('inDocument-Store-data_brand');  //
Route::get('cp/get_all_brand/{name}','ControlPanelController@getAllBrands')->name('get_all_brands');  //
Route::get('cp/get_all_brand_search','ControlPanelController@getAllBrandsSearch')->name('get_all_brands_search');  //
Route::get('cp/add_brand/{id}','ControlPanelController@addBrand')->name('add_Brand');  //
Route::post('cp/add_brand_to_doc','ControlPanelController@addBrandToDoc')->name('add_brand_to_doc');

//
Route::get('cp/select-membership','ControlPanelController@selectMembership')->name('selectMembership');  //


Route::post('cp/ddDocument/store','ControlPanelController@ddElgher')->name('ddElgher-Store');
Route::get('cp/insurance/edit/{id}/{lang?}','ControlPanelController@inDocumentEdit')->name('inDocument-edit');
Route::post('cp/inDocument/update','ControlPanelController@inDocumentUpdate')->name('inDocument-Update');
Route::get('cp/inDocument/delete/{id}','ControlPanelController@inforce')->name('inDocument-delete');
Route::get('cp/inDocument/addNew/{id}/{lang?}','ControlPanelController@addNew')->name('inDocument-addNew');
Route::post('cp/inDocument/add_brands/{id}/{lang?}','ControlPanelController@addBrands')->name('add_brands');
Route::get('cp/inDocument/show_brands/{id}/{lang?}','ControlPanelController@showBrands')->name('inDocument-show-brands');
Route::post('cp/inDocument/change_date/{id}/{lang?}','ControlPanelController@changeDateBrands')->name('change_date_brand');


/*     Newwwwwwwwwwwwwwww    Fawzy Add this     28-5-2020 task  */
Route::post('cp/cmDocument/store','ControlPanelController@cmDocumentStore')->name('cmDocument-Store');
Route::get('cp/cmDocument/edit/{id}/{lang?}','ControlPanelController@cmDocumentEdit')->name('cmDocument-edit');
Route::post('cp/cmDocument/update','ControlPanelController@cmDocumentUpdate')->name('cmDocument-Update');
Route::get('cp/cmDocument/delete/{id}','ControlPanelController@cmforce')->name('cmDocument-delete');


/*     Newwwwwwwwwwwwwwww    sondos     28-5-2020 task  */
Route::get('/cp/accessories/{lang?}','ItemsController@index');
Route::post('cp/accessories/store','ItemsController@store')->name('accessories-Store');
Route::post('cp/accessories/update','ItemsController@update')->name('accessories-Update');
Route::get('cp/accessories/delete/{id}','ItemsController@destroy')->name('accessories-delete');
Route::post('cp/accessories/renew','ItemsController@renewAds')->name('renew_ads_member_from_balance');

Route::get('cp/page',function (){
    return view('test');
});

/*     Newwwwwwwwwwwwwwww    Fawzy     31-5-2020 task  */
Route::get('/document/{lang?}','FrontEndController@dcShow')->name('dcShow');
Route::get('/complete/document/{lang?}','FrontEndController@CompShow')->name('CompShow');
Route::get('/filter/document/{lang}','FrontEndController@dcFilter')->name('dcFilter');
Route::get('/filter/complete/document/{lang}','FrontEndController@ComFilter')->name('ComFilter');
/*     Newwwwwwwwwwwwwwww    sondos   10-6-2020 task  */

Route::post('/user/insurance/{lang?}','FrontEndController@userinsurance')->name('userinsurance');
Route::post('/user/insurancedata/{lang?}','FrontEndController@userinsurancedata')->name('userdata');



// Route::get('/user/insurance/{lang?}','FrontEndController@userinsuranceget')->name('userinsuranceget');

/*     Newwwwwwwwwwwwwwww    sondos    8-6-2020 task  */
Route::get('all/brands/models',function(){

    return \App\brands::with('brands')->get();
    return \App\models;

});
/*     Newwwwwwwwwwwwwwww    sondos    11-6-2020 task  */
Route::get('/insurance/requests/{lang?}','FrontEndController@insurancerequestsuser')->name('insurancerequestsuser');
Route::get('/complete/requests/{lang?}','FrontEndController@complete')->name('complete');

// Route::get('all/insuranceusers/requests',function(){
// $insurancecompany = \App\Insurance::where('user_id',auth()->user()->id)->first();
// $insurancerequests = \App\userinsurance::where('insurance_id',$insurancecompany->id)->get();

// return $insurancerequests;

// });
Route::get('/insurance/thanks/{lang?}','FrontEndController@insurancethanks')->name('insurancethanks');


Route::get('/insurance/delete/{id?}','ControlPanelController@deleteinDocument')->name('deleteinDocument');

/** Wael Add this **/

Route::get('/insurace/comp/create/{lang?}','ControlPanelController@compDocumentCreate')->name('com.create');
Route::get('/insurace/docChangeStatus','ControlPanelController@docChangeStatus');
Route::get('/insurace/docChangeShowStatus','ControlPanelController@docChangeShowStatus');
Route::get('/insurace/deleteDoc/{id}','ControlPanelController@deleteDoc')->name('delete_com_doc');
Route::get('/insurace/deleteDocAddon','ControlPanelController@deleteDocAddon');
Route::get('/insurace/deletecondition','ControlPanelController@deletecondition');
Route::post('/insurace/update_brad','ControlPanelController@UpdateBrand')->name('update_brand');


Route::post('/submitCompleteDoc','FrontEndController@submitCompleteDoc')->name('submitCompleteDoc')->middleware('auth');
Route::post('/submitCompleteDoc/changeStatus','FrontEndController@submitCompleteDocChangeStaus')->name('submitCompleteDocChangeStatus')->middleware('auth');
Route::get('/hidden_request/{id}','FrontEndController@hiddenRequest')->name('hidden_request')->middleware('auth');


//website moduke
Route::get('/dashboard/website','WebsiteController@edit')->name('edit-website');
Route::post('/dashboard/website/update','WebsiteController@update_model')->name('update-website');

Route::get('/memberships/join/{lang?}',function($lang = null){
    if($lang)
    {
        if($lang == 'ar' || $lang == 'en')
        {
            App::setlocale($lang);
        }
        else
        {
            App::setlocale('ar');
        }

    }
    else{
        App::setlocale('ar');
    }
    return view('content.memberships');
});

Route::post('user/charge-balance','PaymentController@index')->name('charge_balance');
Route::get('user/success_payment','PaymentController@successPayment')->name('success_payment');
// travel
Route::get('cdashboard/edit_company_travel/{lang}','TravelController@editCompany')->name('edit_travel_com');




///// end user
//////// start dashboard
Route::get('/dashboard/Comp-insurance' , function(){
    $CompleteDocs = \App\CompleteDoc::paginate(15);
    return view ('dashboard.insurance.index',compact('CompleteDocs'));
})->name('Comp-insurnace-index');
Route::get('/dashboard/Incomp-insurance' , function(){
    $IncompleteDocs = \App\InsuranceDocument::orderBy('id','Desc')->paginate(15);
    return view ('dashboard.insurance.incompleteIns',compact('IncompleteDocs'));
})->name('inc-insurnace-index');
Route::get('/dashboard/deleteCop-doc/{id?}' , 'ControlPanelController@CompDoc_delete')->name('delete-ComDoc');
Route::get('/dashboard/deleteInc-doc/{id?}' , 'ControlPanelController@IncCompDoc_delete')->name('delete-InComDoc');

//Task Acyive & In Active Insurnace
Route::get('/dashboard/active/complete-doc/{id?}' , 'ControlPanelController@CompDoc_active')->name('active-comp');
Route::get('/dashboard/deactive/complete-doc/{id?}' , 'ControlPanelController@CompDoc_deactive')->name('deactive-comp');

Route::get('/dashboard/active/Incompelet-doc/{id?}' , 'ControlPanelController@IncCompDoc_active')->name('active-IncComp');
Route::get('/dashboard/deactive/Incomplete-doc/{id?}' , 'ControlPanelController@IncCompDoc_deactive')->name('deactive-IncComp');

//Task 21-10-2020
Route::get('/about-us/{lang?}', function($lang=null){
    if($lang == 'ar' || $lang == 'en')
    {
        App::setlocale($lang);
    }
    else
    {
        App::setlocale('ar');
    }
    return view('content.about');
})->name('about-us');

//Route::get('dashboard/insurnace/company' , function(){
//
//    return view('dashboard.insurance.company');
//})->name('insurnace-companies');
Route::get('dashboard/insurnace/company', 'CompanyController@index')->name('insurnace-companies');


Route::get('dashboard/insurnace/companyChangeStatus', 'CompanyController@companyChangeStatus');


//Task Actiuve And Deactive Insurances Company

Route::post('/dashboard/active-insurnace' , 'ControlPanelController@active_insurnace')->name('active-insurance');
Route::post('/dashboard/deactive-insurnace' , 'ControlPanelController@deactive_insurnace')->name('deactive-insurance');


//mcenter vehicle
Route::resource('/dashboard/mcentervehicles' , 'McenterVehicleController')->except(['show','create']);
Route::get('/dashboard/mcentervehicles/vehicleChangeStatus' , 'McenterVehicleController@VehicleChangeStatus')->name('VehicleChangeStatus');
Route::get('/dashboard/mcentervehicles/create' , 'McenterVehicleController@create')->name('mcentervehicles.create');
Route::get('/dashboard/mcentervehicles/{id}' , 'McenterVehicleController@delete')->name('mcentervehicles.delete');
Route::post('/dashboard/mcentervehicles/search' , 'McenterVehicleController@index')->name('mcentervehicles.search');

//vehicle
Route::resource('/dashboard/vehicles' , 'VehicleController')->except(['show','create']);
Route::get('/dashboard/vehicles/vehicleChangeStatus' , 'VehicleController@VehicleChangeStatus')->name('VehicleChangeStatus');
Route::get('/dashboard/vehicles/create' , 'VehicleController@create')->name('vehicles.create');
Route::get('/dashboard/vehicles/{id}' , 'VehicleController@delete')->name('vehicles.delete');
Route::post('/dashboard/vehicles/search' , 'VehicleController@index')->name('vehicles.search');


//CareShape
Route::resource('/dashboard/careshapes' , 'CareShapeController')->except(['show','create']);
Route::get('/dashboard/careshapes/careshapeChangeStatus' , 'CareShapeController@careshapeChangeStatus')->name('careshapeChangeStatus');
Route::get('/dashboard/careshapes/create' , 'CareShapeController@create')->name('careshapes.create');
Route::get('/dashboard/careshapes/{id}' , 'CareShapeController@delete')->name('careshapes.delete');
Route::post('/dashboard/careshapes/search' , 'CareShapeController@index')->name('careshapes.search');


//brands
Route::resource('/dashboard/brands' , 'BrandController')->except('show');
Route::get('/dashboard/brands/brandChangeStatus' , 'BrandController@brandChangeStatus')->name('brandChangeStatus');
Route::get('/dashboard/brands/create' , 'BrandController@create')->name('brands.create');
Route::get('/dashboard/brands/{id}' , 'BrandController@delete')->name('brands.delete');
Route::post('/dashboard/brands/search' , 'BrandController@index')->name('brands.search');

//models
Route::resource('/dashboard/models' , 'ModelController')->except('show');
Route::get('/dashboard/models/{id}' , 'ModelController@delete')->name('models.delete');
Route::post('/dashboard/models/search' , 'ModelController@index')->name('models.search');


//service categories
// Route::get('/dashboard/service_categories/service_categoryChangeStatus' , 'ServiceCategoryController@service_categoryChangeStatus')->name('serviceCategoryChangeStatus');
Route::resource('/dashboard/service_categories' , 'ServiceCategoryController')->except(['show','create']);
Route::get('/dashboard/service_categories/create' , 'ServiceCategoryController@create')->name('service_categories.create');
Route::get('/dashboard/service_categories/{id}' , 'ServiceCategoryController@delete')->name('service_categories.delete');
Route::post('/dashboard/service_categories/search' , 'ServiceCategoryController@index')->name('service_categories.search');
Route::get('/dashboard/service_categories/get-childrens/{id}' , 'ServiceCategoryController@getChildrens')->name('service_categories.get-childrens');

//service sub categories
// Route::get('/dashboard/service_sub_categories/service_sub_categoryChangeStatus' , 'ServiceSubCategory@service_sub_categoryChangeStatus')->name('serviceSubCategoryChangeStatus');
Route::resource('/dashboard/service_sub_categories' , 'ServiceSubCategoryController')->except(['show','create']);
Route::get('/dashboard/service_sub_categories/create' , 'ServiceSubCategoryController@create')->name('service_sub_categories.create');
Route::get('/dashboard/service_sub_categories/{id}' , 'ServiceSubCategoryController@delete')->name('service_sub_categories.delete');
Route::post('/dashboard/service_sub_categories/search' , 'ServiceSubCategoryController@index')->name('service_sub_categories.search');
Route::get('/dashboard/service_sub_categories/get-childrens/{id}' , 'ServiceSubCategoryController@getChildrens')->name('service_sub_categories.get-childrens');

//service child categories
Route::resource('/dashboard/service_child_categories' , 'ServiceChildCategoryController')->except(['show','create']);
Route::get('/dashboard/service_child_categories/create' , 'ServiceChildCategoryController@create')->name('service_child_categories.create');
Route::get('/dashboard/service_child_categories/{id}' , 'ServiceChildCategoryController@delete')->name('service_child_categories.delete');
Route::post('/dashboard/service_child_categories/search' , 'ServiceChildCategoryController@index')->name('service_child_categories.search');

//stores
Route::resource('/dashboard/stores' , 'StoreController')->except(['show','create']);
Route::get('/dashboard/stores/create' , 'StoreController@create')->name('stores.create');
Route::get('/dashboard/stores/{id}' , 'StoreController@delete')->name('stores.delete');
Route::post('/dashboard/stores/search' , 'StoreController@index')->name('stores.search');
Route::post('/dashboard/store/get' , 'StoreController@getStores')->name('stores.get');

//service_member_ships
Route::resource('/dashboard/service_member_ships' , 'ServiceMemberShipController')->except(['show','create']);
Route::get('/dashboard/service_member_ships/create' , 'ServiceMemberShipController@create')->name('service_member_ships.create');
Route::get('/dashboard/service_member_ships/{id}' , 'ServiceMemberShipController@delete')->name('service_member_ships.delete');
Route::post('/dashboard/service_member_ships/search' , 'ServiceMemberShipController@index')->name('service_member_ships.search');
Route::post('/dashboard/service_member_ships/get' , 'ServiceMemberShipController@getServiceMemberShip')->name('service_member_ships.get');


//uses
Route::resource('/dashboard/uses' , 'UseController')->except('show');
Route::get('/dashboard/uses/{id}' , 'UseController@delete')->name('uses.delete');
Route::get('/dashboard/documents' , 'UseController@documents')->name('uses.docs');

//notify
Route::get('/dashboard/notify' , 'NotifyController@index')->name('admin_notify');
Route::get('/dashboard/notify/watched/{id}' , 'NotifyController@watchAds')->name('notify.eye');
Route::get('/dashboard/notify/delete/{id}' , 'NotifyController@delete')->name('notify.delete');

//items
Route::get('/dashboard/items' , 'NotifyController@showItem')->name('dash.items');
Route::post('/dashboard/items' , 'NotifyController@showItem');
Route::get('/dashboard/items/itemChangeStatus' , 'NotifyController@itemChangeStatus')->name('itemChangeStatus');
Route::get('/dashboard/items/show' , 'NotifyController@itemshow')->name('dash.items.show');
Route::post('/dashboard/items/renew_date_item' , 'NotifyController@renewItem')->name('dashboard_renew_date_item');

//price
Route::resource('/dashboard/prices' , 'PriceController')->except('show');
Route::get('/dashboard/prices/{id}' , 'PriceController@delete')->name('prices.delete');
//dep-memberships
Route::resource('/dashboard/dep-memberships' , 'DepatementMembershipController')->except('show');
Route::get('/dashboard/dep-memberships/{id}' , 'DepatementMembershipController@delete')->name('dep-memberships.delete');

//notification price
Route::resource('/dashboard/notification-price' , 'NotificationPriceController')->except(['show','destroy']);
Route::get('/dashboard/notification-price/{id}' , 'NotificationPriceController@destroy')->name('notification-price.destroy');
//dep-memberships
Route::resource('/dashboard/ads-memberships' , 'AdsMembershipController')->except('show');
Route::get('/dashboard/ads-memberships/{id}' , 'AdsMembershipController@delete')->name('dep-memberships.delete');

Route::get('/dashboard/send/mail' , 'EmailController@showUsers')->name('email.show');
Route::post('/dashboard/sent/mail' , 'EmailController@sendEmail')->name('send_email_to_users');

//member-insurance
Route::resource('/dashboard/member-insurance' , 'MemberInsuranceController')->except('show');
Route::get('/dashboard/member-insurance/{id}' , 'MemberInsuranceController@delete')->name('memberInsurance.delete');

Route::get('/dashboard/increase-date/{type}' , 'IncreseController@increase')->name('increase-date');
Route::post('/dashboard/renew-date/{user}/{type}' , 'IncreseController@renew')->name('date.renew');
Route::get('/dashboard/add-price/users' , 'IncreseController@addPriceToUsers')->name('increase-price-user');
Route::post('/dashboard/charge-price/{id}' , 'IncreseController@chargePrice')->name('charge_balance_user');
