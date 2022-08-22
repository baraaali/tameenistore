<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['lang'],'namespace'=>'Api'],function (){
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::get('home', 'MainController@home');
    //countries
    Route::get('countries', 'MainController@countries');
    Route::get('countries-cities', 'MainController@countriesWithCities');
    Route::get('country/{id}', 'MainController@country');
    Route::get('country-city/{id}', 'MainController@countryWithCity');
    //membership
    Route::get('membership-cars', 'MainController@membershipCars');
    Route::get('membership-deps', 'MainController@membershipDeps');
    //categories
    Route::get('categories', 'MainController@categories');
    Route::post('departments/search', 'MainController@searchDepartment');
    Route::get('all-departments', 'MainController@allDepartments');
    Route::get('department/{id}', 'MainController@department');
    Route::get('show-item-details/{id}', 'MainController@showItemsDetails');
    //barands
    Route::get('brands', 'MainController@brands');
    Route::get('models', 'MainController@models');
    Route::get('uses', 'MainController@uses');
    Route::get('brand-with-models', 'MainController@brandsWithModels');
    //agency
    Route::get('rent-agents', 'MainController@rentAgency');
    Route::post('agents/search', 'MainController@rentAgencySearch');
    //Route::post('sale-agents/search/1', 'MainController@agencySearch');
    //car rent-agents
    Route::get('all-agents-car/{id}', 'CarController@allAgencyCars');
    Route::get('cars-sale-agents', 'MainController@saleAgency');

    //cars
    Route::get('cars-sale', 'CarController@carSale');
    Route::post('cars-sale/search', 'CarController@carSaleSearch');
    Route::post('cars-rent/search', 'CarController@carRentSearch');
    Route::get('cars-rent', 'CarController@carRent');
    Route::get('ads', 'CarController@ads');
    Route::post('search-ads', 'CarController@Searchads');
    Route::get('car-details/{id}', 'CarController@carDetails');
    Route::get('memberships','AgentController@membership');

    //about
    Route::get('about-us', 'MainController@about');
    //seaarch tameen
    Route::post('search-tameen-shamel', 'MainController@searchShamel');
    Route::get('get-add-conditions/{name}/{id}','TameenController@getAddations');
    Route::post('search-tameen-other', 'MainController@searchTameenOther');
//password
    //code
    Route::get('rest-password', 'MainController@restPassword');

    Route::group(['middleware'=>'auth:api'],function (){
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');

        Route::get('user/{id}', 'AuthController@getUser');
        Route::post('update-agency', 'AuthController@updateAgency');
        Route::post('update-user', 'AuthController@updateUserDetails');
        //notify
        Route::get('ads/notify', 'CarController@adsNotify');
        Route::post('send-request', 'CarController@booking');
        //tameen shamel
        Route::get('select_membership','TameenController@selectMemberShip');
        Route::get('check-user-subscribe','TameenController@userSubscribe');
        Route::get('check-user-upload-document','TameenController@checkUserUploadDocument');
        Route::get('check-possible-add','TameenController@checkPossibleAdd');
        Route::get('get-all-brands','TameenController@getAllBrands');
        Route::get('show-all-user-complete-tameen','TameenController@getAllComplete');
        Route::post('delete-complete-tameen','TameenController@deleteCompleteTameen');
        Route::post('update-brand','TameenController@updateBrand');
        Route::post('change-complete-status','TameenController@ChangeCompleteStatus');
        Route::post('add-brand','TameenController@addBrand');
        Route::post('subscribe-membership','TameenController@subscribeMembership');
        Route::post('add-complete-tameen','TameenController@addCompleteTameen');
        Route::get('edit-complete-tameen/{id}','TameenController@editCompleteTameen');
        Route::post('update-complete-tameen/{id}','TameenController@updateCompleteTameen');
        Route::get('complete-tameen-requests','TameenController@completeRequestTameen');
        Route::post('complete-tameen-request-delete/{id}','TameenController@completeRequestTameenDelete');
        Route::post('send-request-complete-tameen','TameenController@sendCompleteRequest');
        Route::post('change-status-complete-tameen','TameenController@changeStatus');
        Route::post('hidden-complete-tameen','TameenController@hiddenRequest');
        Route::get('show-all-requests-complete','TameenController@requestsTameen');

        /////////// other tameen
        Route::get('show-all-user-other-tameen','OtherTameenController@getAllother');
        Route::get('show-other-tameen/{id}','OtherTameenController@showTameen');
        Route::get('show-all-brand-other/{id}','OtherTameenController@showAllOtherBrands');
        Route::post('add-other-tameen','OtherTameenController@addOtherTameen');
        Route::post('edit-other-tameen/{id}','OtherTameenController@editOtherTameen');
        Route::post('add-brand-other-tameen','OtherTameenController@addBrand');
        Route::post('delete-other-tameen','OtherTameenController@deleteOtherTameen');
        Route::get('show-request-other-tameen','OtherTameenController@showRequestOther');//to do
        Route::post('send-request-other-tameen','OtherTameenController@sendRequestOther');//to do
        Route::delete('delete-request-other-tameen/{id}','OtherTameenController@deleteRequestOther');//to do
  //car type
        Route::post('upload-user-documents','AgentController@uploadUserDocuments');
        Route::get('show-user-ads','AgentController@showUserAds');
        Route::get('get-ad/{id}','AgentController@getUserAd');
        Route::post('update-ad','AgentController@updateAd');
        Route::post('add-new-ad','AgentController@AddNewAd');
        Route::post('renew-ad','AgentController@renewAdsFromBalance');
        Route::delete('delete-ad/{id}','AgentController@deleteAd');

        //sub cats
        Route::get('get-all-sub-cats','SubDepController@getAllSubCat');
        Route::get('get-sub-cat/{id}','SubDepController@getSubCat');
        Route::post('add-sub-cat','SubDepController@addSub');
        Route::post('update-sub-cat','SubDepController@updateSubCat');
        Route::delete('delete-sub-cat/{id}','SubDepController@delete');
        Route::delete('delete-order/{id}','SubDepController@deleteOrder');
        Route::get('show-sub-cat-orders','SubDepController@showOrders');
        Route::get('show-order/{id}','SubDepController@showOrder');
        Route::post('renew-departement','SubDepController@renewDepartement');

        //charge
        Route::post('charge','UserController@charge');
//notification
        Route::post('create-token','UserController@createToken');
        Route::post('delete-token','UserController@deleteToken');
        Route::get('all-user-token','UserController@getUserToken');
        Route::get('show-user-balance','UserController@showUserbalance');//to do

        //setting
       //Route::get('settings','MainController@settings');


    });
});
Route::group(['middleware'=>['lang','checkPassword'],'namespace'=>'Api'],function (){
    Route::post('me', 'AuthController@me');
});
