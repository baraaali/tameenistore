<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Mcenters;
use App\NotificationPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct()
    {
     $this->middleware('auth');
    }
    public function index()
    {
        $balance = 0;
        $balance=Balance::where('user_id',auth()->user()->id)->first();
        if($balance) 
        $balance = $balance->balance;

        $packages = NotificationPrice::get();

        if(auth()->user()->guard == 0)
    	return view('dashboard.dashboard-user',compact('balance','packages'));
    	return view('dashboard.index');
    }

    public function renewMemebershipMcenter(Request $request)
    {
        if(auth()->user()->mcenter)
        {
            $mcenter_id =  auth()->user()->mcenter->id;
            $user_id =  auth()->user()->id;
            $mcenter =Mcenters::where('id',$mcenter_id)->first();
            $balance=Balance::where('user_id',$user_id)->first();
            $membership = $mcenter->serviceMemberShip;
        
            //dd($user_id);
            // get renewal date
            if ($mcenter->renewal_at < date('Y-m-d'))
            $date =  strtotime(date('Y-m-d'). ' + '.$mcenter->serviceMemberShip->months_number.' Month');
            else
            $date =  strtotime($mcenter->renewal_at. ' + '.$mcenter->serviceMemberShip->months_number.' Month');
    
            // set new date
            $mcenter->renewal_at =  Date('Y-m-d',$date);
            if ((isset($balance) && $balance->balance >= $membership->price) || $membership->price == 0){
                      if(isset($balance))
                      {
                        $user_balance= floatval($balance->balance) - floatval($membership->price);
                        $balance->update(['balance'=>$user_balance]);
                      }
                      $mcenter->save();
                      transaction($user_id,'out',$membership->price,'mcenters',0);
                      Session::flash('success', 'تم تجديد الإشتراك بنجاح');
                }else{
                    Session::flash('error', 'لا يوجد لديك رصيد كافي');
                }
                return back();
            

         
    

        }
        return 0;
    }
}
